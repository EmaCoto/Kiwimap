<?php

namespace App\Console\Commands;

use App\Models\{License, LicenseNotificationLog, User};
use App\Notifications\LicenseExpiringNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SendLicenseReminders extends Command
{
    protected $signature = 'licenses:send-reminders {--id=}';
    protected $description = 'Envía recordatorios por licencias (pre-exp y post-exp controlado)';

    private array $offsets = [90, 75, 60, 45, 30, 15, 0, -15, -30];

    public function handle(): int
    {
        $today = Carbon::today();
        $sent = 0;

        if ($this->option('id')) {
            $licenses = License::where('id', $this->option('id'))->get();
        } else {
            $licenses = License::whereNotNull('expiration_date')->get();
        }

        foreach ($licenses as $l) {
            $daysUntil = (int) $today->diffInDays($l->expiration_date, false);

            if (!in_array($daysUntil, $this->offsets, true)) continue;
            if ($daysUntil < 0 && $l->status === 'active') continue;

            $already = LicenseNotificationLog::where('license_id', $l->id)
                ->where('offset_days', $daysUntil)
                ->exists();
            if ($already) continue;

            $recipients = User::role('Admin')->get();

            if ($recipients->isEmpty()) {
                Log::warning("No recipients with 'Admin' role found. Notification not sent.");
                continue;
            }

            foreach ($recipients as $user) {
                $user->notify(new LicenseExpiringNotification($l, $daysUntil));
                $sent++;
            }

            LicenseNotificationLog::create([
                'license_id'  => $l->id,
                'offset_days' => $daysUntil,
                'sent_at'     => now(),
            ]);

            Log::info("ENVIADO Lic#{$l->id} offset {$daysUntil} a " . $recipients->pluck('email')->implode(', '));
        }

        $this->info("Recordatorios procesados. Enviados: {$sent}");
        return self::SUCCESS;
    }
}