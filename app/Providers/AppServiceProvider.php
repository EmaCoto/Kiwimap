<?php

namespace App\Providers;

use App\Models\License;
use App\Observers\LicenseObserver;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Information\Index as InformationIndex;
use App\Policies\InformationPolicy;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::policy(InformationIndex::class, InformationPolicy::class);

        // 🔔 Disparo inmediato al guardar si cae en offset
        License::observe(LicenseObserver::class);

        // ⏰ Cron diario (para pruebas usaremos ejecución manual)
        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command('licenses:send-reminders')->daily();
        });

        // 🛡️ Si el usuario es Admin, autoriza todo antes de evaluar policies
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
    }
}
