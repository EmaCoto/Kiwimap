<?php

namespace App\Observers;

use App\Models\License;
use App\Models\LicenseNotificationLog;
use App\Models\User;
use App\Notifications\LicenseExpiringNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class LicenseObserver
{
    private array $offsets = [90, 75, 60, 45, 30, 15, 0, -15, -30];

    public function updated(License $license): void
    {
        if (blank($license->expiration_date)) return;

        // Solo si cambió expiración o status
        if (! $license->wasChanged(['expiration_date', 'status'])) return;

        $this->maybeNotify($license);
    }

    public function created(License $license): void
    {
        if (blank($license->expiration_date)) return;

        $this->maybeNotify($license);
    }

    private function maybeNotify(License $license): void
    {
        $today     = Carbon::today();
        $daysUntil = $today->diffInDays($license->expiration_date, false);

        // Solo en los offsets que definiste
        if (! in_array($daysUntil, $this->offsets, true)) return;

        // Si ya venció pero sigue en active, no notificar
        if ($daysUntil < 0 && $license->status === 'active') return;

        // Evitar reenvíos para el mismo offset
        $already = LicenseNotificationLog::where('license_id', $license->id)
            ->where('offset_days', $daysUntil)
            ->exists();
        if ($already) return;

        $recipients = $this->collectRecipients($license);

        if ($recipients->isEmpty()) {
            Log::warning("No recipients (Admin/Office Manager/Doctor) found for license {$license->id}. Notification not sent.");
            return;
        }

        foreach ($recipients as $user) {
            $user->notify(new LicenseExpiringNotification($license, $daysUntil));
        }

        LicenseNotificationLog::create([
            'license_id'  => $license->id,
            'offset_days' => $daysUntil,
            'sent_at'     => now(),
        ]);
    }

    /**
     * Admins + Office Managers + doctor dueño de la licencia.
     * Filtra duplicados y emails vacíos.
     */
    private function collectRecipients(License $license): Collection
    {
        $guard = config('auth.defaults.guard', 'web');

        $admins = User::role('Admin', $guard)->get();
        $offices = User::role('Office Manager', $guard)->get();

        $doctorUser = optional($license->doctor)->user; // puede ser null

        $all = $admins
            ->merge($offices)
            ->when($doctorUser, fn ($c) => $c->push($doctorUser));

        return $all
            ->filter(fn ($u) => filled($u->email))
            ->unique('id')
            ->values();
    }
}
