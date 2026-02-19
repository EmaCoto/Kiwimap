<?php

namespace App\Livewire\Dashboard;

use App\Models\{Doctor, License, State};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Metrics extends Component
{
    use AuthorizesRequests;

    #[Url] public int $soonDays = 90; // configurable por query: /dashboard?soonDays=45

    public int $operationalStates = 0;
    public int $doctorsCount = 0;
    public int $licensesCount = 0;
    public int $expiringSoonCount = 0;

    public array $byStatus = [
        'active'  => 0,
        'renovation' => 0,
        'expired' => 0,
    ];

    public $expiringSoon; // collection

    public function mount(): void
    {    

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

    public function clearCaches(): void
    {
        // ✅ Seguridad: solo Admin u Office Manager
        if (! auth()->user()?->hasAnyRole(['Admin','Office Manager'])) {
            abort(403);
        }

        // (Opcional) extra seguridad en producción
        // if (app()->isProduction()) { abort(403, 'Solo en entornos autorizados.'); }

        $commands = [
            'optimize:clear', // limpia todo (config, route, view, cache, etc.)
            'event:clear',
            'queue:restart',  // reinicia workers de colas
        ];

        foreach ($commands as $cmd) {
            try {
                Artisan::call($cmd);
            } catch (\Throwable $e) {
                Log::error("Fallo ejecutando {$cmd}: ".$e->getMessage());
            }
        }

        // Feedback en UI
        session()->flash('ok', 'Cachés limpiadas.');
    }

    public function render()
    {
        return view('livewire.dashboard.metrics');
    }
}
