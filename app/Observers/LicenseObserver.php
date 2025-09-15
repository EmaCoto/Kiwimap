<?php

namespace App\Observers;

use App\Models\License;
use App\Models\LicenseNotificationLog;
use App\Models\User;
use App\Notifications\LicenseExpiringNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LicenseObserver
{
    private array $offsets = [90, 75, 60, 45, 30, 15, 0, -15, -30];

    public function updated(License $license): void
    {
        if (blank($license->expiration_date)) {
            return;
        }

        // Solo actúa si cambió la fecha de expiración o el status
        if (! $license->wasChanged(['expiration_date', 'status'])) {
            return;
        }

        $today = Carbon::today();
        $daysUntil = $today->diffInDays($license->expiration_date, false);

        if (! in_array($daysUntil, $this->offsets, true)) {
            return;
        }

        if ($daysUntil < 0 && $license->status === 'active') {
            return;
        }

        $already = LicenseNotificationLog::where('license_id', $license->id)
            ->where('offset_days', $daysUntil)
            ->exists();

        if ($already) {
            return;
        }

        $recipients = User::role('Admin')->get();

        if ($recipients->isEmpty()) {
            Log::warning("No recipients with 'Admin' role found. Notification not sent.");
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

    public function created(License $license): void
    {
        if (blank($license->expiration_date)) {
            return;
        }

        $today     = Carbon::today();
        $daysUntil = $today->diffInDays($license->expiration_date, false);

        if (! in_array($daysUntil, $this->offsets, true)) {
            return;
        }

        if ($daysUntil < 0 && $license->status === 'active') {
            return;
        }

        $already = LicenseNotificationLog::where('license_id', $license->id)
            ->where('offset_days', $daysUntil)
            ->exists();

        if ($already) {
            return;
        }

        $recipients = User::role('Admin')->get();

        if ($recipients->isEmpty()) {
            Log::warning("No recipients with 'Admin' role found. Notification not sent.");
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
}