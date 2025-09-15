<?php

namespace App\Providers;

use App\Models\License;
use App\Observers\LicenseObserver;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // 🔔 Disparo inmediato al guardar si cae en offset
        License::observe(LicenseObserver::class);

        // ⏰ Cron diario (para pruebas usaremos ejecución manual)
        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command('licenses:send-reminders')->daily();
        });
    }
}

