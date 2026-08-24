<?php

namespace App\Livewire\Dashboard;

use App\Models\{Doctor, License, State, User};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;
use Livewire\Component;

class Metrics extends Component
{
    use AuthorizesRequests;

    #[Url] public int $soonDays = 90;

    public int $operationalStates = 0;
    public int $doctorsCount = 0;
    public int $licensesCount = 0;
    public int $expiringSoonCount = 0;

    public array $byStatus = [
        License::STATUS_ACTIVE => 0,
        License::STATUS_RENOVATION => 0,
        License::STATUS_EXPIRED => 0,
    ];

    /**
     * @var \Illuminate\Database\Eloquent\Collection<int, License>
     */
    public $expiringSoon;

    /**
     * @var \Illuminate\Database\Eloquent\Collection<int, User>
     */
    public $hipaaExpiringSoon;

    public function mount(): void
    {
        $this->operationalStates = State::query()->where('is_operational', true)->count();
        $this->doctorsCount = Doctor::query()->count();
        $this->licensesCount = $this->visibleLicensesQuery()->count();

        $statusCounts = $this->visibleLicensesQuery()
            ->selectRaw(License::normalizedStatusCaseSql('status').' as normalized_status, COUNT(*) as c')
            ->groupBy('normalized_status')
            ->pluck('c', 'normalized_status');

        foreach (License::canonicalStatuses() as $status) {
            $this->byStatus[$status] = (int) ($statusCounts[$status] ?? 0);
        }

        $today = now()->startOfDay();
        $until = now()->addDays($this->soonDays)->endOfDay();

        $expiringSoonQuery = $this->visibleLicensesQuery()
            ->with(['doctor.user:id,name', 'state:id,name,code'])
            ->whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [$today, $until])
            ->orderBy('expiration_date')
            ->orderBy('id');

        $this->expiringSoon = (clone $expiringSoonQuery)
            ->limit(10)
            ->get();

        $this->expiringSoonCount = (clone $expiringSoonQuery)->count();

        $hipaaUntil = $today->copy()->addDays(30);

        $this->hipaaExpiringSoon = User::query()
            ->select(['id', 'name', 'hipaa_course_expiration_date'])
            ->whereNotNull('hipaa_course_expiration_date')
            ->whereDate('hipaa_course_expiration_date', '<=', $hipaaUntil->toDateString())
            ->orderBy('hipaa_course_expiration_date')
            ->orderBy('name')
            ->get();
    }

    /**
     * @return Builder<License>
     */
    private function visibleLicensesQuery(): Builder
    {
        /** @var User|null $user */
        $user = request()->user();

        return License::query()->visibleToUser($user);
    }

    public function clearCaches(): void
    {
        /** @var User|null $user */
        $user = request()->user();

        if (! $user || ! $user->hasAnyRole(['Admin', 'Office Manager'])) {
            abort(403);
        }

        $commands = [
            'optimize:clear',
            'event:clear',
            'queue:restart',
        ];

        foreach ($commands as $cmd) {
            try {
                Artisan::call($cmd);
            } catch (\Throwable $e) {
                Log::error("Fallo ejecutando {$cmd}: ".$e->getMessage());
            }
        }

        session()->flash('ok', 'Caches limpiadas.');
    }

    public function render()
    {
        return view('livewire.dashboard.metrics');
    }
}
