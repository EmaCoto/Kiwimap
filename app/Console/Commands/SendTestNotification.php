<?php

namespace App\Console\Commands;

use App\Models\{License, LicenseNotificationLog, User};
use App\Notifications\LicenseExpiringNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class SendTestNotification extends Command
{
    protected $signature = 'licenses:send-test-notification {licenseId}';
    protected $description = 'Sends a test notification for a specific license ID.';
    
    private array $offsets = [90, 75, 60, 45, 30, 15, 0, -15, -30];

    public function handle(): int
    {
        $licenseId = $this->argument('licenseId');
        
        try {
            $license = License::find($licenseId);

            if (!$license) {
                $this->error("License with ID {$licenseId} not found.");
                return self::FAILURE;
            }

            $today = Carbon::today();
            $daysUntil = $today->diffInDays($license->expiration_date, false);

            // FIX: Removido el chequeo estricto para evitar fallas de tipo.
            if (!in_array((int)$daysUntil, $this->offsets)) {
                $this->info("Days until expiration ({$daysUntil}) is not in offsets. No action taken.");
                return self::SUCCESS;
            }
            
            $alreadySent = LicenseNotificationLog::where('license_id', $license->id)
                ->where('offset_days', $daysUntil)
                ->exists();

            if ($alreadySent) {
                $this->info("Notification already sent for this offset. No action taken.");
                return self::SUCCESS;
            }

            $recipients = User::role('Admin')->get();

            if ($recipients->isEmpty()) {
                $this->warn("No 'Admin' role recipients found. Check your roles configuration.");
                return self::FAILURE;
            }
            
            foreach ($recipients as $user) {
                $user->notify(new LicenseExpiringNotification($license, $daysUntil));
                $this->info("Notification sent to {$user->email}.");
            }
            
            LicenseNotificationLog::create([
                'license_id'  => $license->id,
                'offset_days' => $daysUntil,
                'sent_at'     => now(),
            ]);

            $this->info("Log entry created for license ID {$license->id}.");

        } catch (Exception $e) {
            $this->error("An unexpected error occurred: " . $e->getMessage());
            Log::error("Unhandled exception in command: " . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}