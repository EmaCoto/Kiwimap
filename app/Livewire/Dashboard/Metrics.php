<?php

namespace App\Livewire\Dashboard;

use App\Models\{Doctor, License, State};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;

class Metrics extends Component
{
    use AuthorizesRequests;

    #[Url] public int $soonDays = 30; // configurable por query: /dashboard?soonDays=45

    public int $operationalStates = 0;
    public int $doctorsCount = 0;
    public int $licensesCount = 0;
    public int $expiringSoonCount = 0;

    public array $byStatus = [
        'active'  => 0,
        'pending' => 0,
        'expired' => 0,
    ];

    public $expiringSoon; // collection

    public function mount(): void
    {
        // Permisos generales (ajusta según tus policies)
        $this->authorize('viewAny', State::class);
        $this->authorize('viewAny', Doctor::class);
        $this->authorize('viewAny', License::class);

        $this->operationalStates = State::where('is_operational', true)->count();
        $this->doctorsCount      = Doctor::count();
        $this->licensesCount     = License::count();

        // Distribución por status
        $statusCounts = License::selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status');

        foreach (['active','pending','expired'] as $k) {
            $this->byStatus[$k] = (int) ($statusCounts[$k] ?? 0);
        }

        $today = now()->startOfDay();
        $until = now()->addDays($this->soonDays)->endOfDay();

        $this->expiringSoon = License::with(['doctor.user:id,name','state:id,name,code'])
            ->whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [$today, $until])
            ->orderBy('expiration_date')
            ->limit(10)
            ->get();

        $this->expiringSoonCount = License::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [$today, $until])
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard.metrics');
    }
}
