<?php

namespace App\Notifications;

use App\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseExpiringNotification extends Notification
{
    use Queueable;

    public function __construct(
        public License $license,
        public int $daysUntil 
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $l = $this->license->loadMissing('doctor.user','state');

        $doctor = $l->doctor?->user?->name ?? '—';
        $state  = trim(($l->state?->name ?? '—').' ('.($l->state?->code ?? '—').')');
        $exp    = optional($l->expiration_date)->toFormattedDateString() ?? '—';

        if ($this->daysUntil > 0) {
            $subject = "Aviso: Licencia próxima a vencer en {$this->daysUntil} días — $doctor ($state)";
            $title   = 'Licencia próxima a vencer';
            $line1   = "La licencia indicada expira en {$this->daysUntil} días (límite: {$exp}).";
        } elseif ($this->daysUntil === 0) {
            $subject = "⚠️ Hoy expira la licencia: $doctor — $state";
            $title   = 'Licencia vence HOY';
            $line1   = "La licencia indicada expira hoy ({$exp}).";
        } else {
            $daysAgo = abs($this->daysUntil);
            $subject = "Licencia vencida hace {$daysAgo} días — $doctor ($state)";
            $title   = 'Licencia vencida';
            $line1   = "La licencia indicada venció el {$exp} (hace {$daysAgo} días).";
        }

        $url = route('licenses.edit', $l);

        return (new MailMessage)
            ->subject($subject)
            ->greeting($title)
            ->line($line1)
            ->line("• Doctor: **$doctor**")
            ->line("• Estado: **$state**")
            ->line("• Expiración: **$exp**")
            ->line("• Status actual: **".ucfirst($l->status)."**")
            ->action('Revisar / Actualizar licencia', $url)
            ->line('Este es un recordatorio automático. Tras la fecha de expiración, se enviarán hasta 2 recordatorios quincenales si la licencia no está activa.');


    }

}


$lic = \App\Models\License::inRandomOrder()->first();
\App\Models\LicenseNotificationLog::where('license_id', $lic->id)->delete();

$lic->expiration_date = now()->subDays(15)->toDateString();
$lic->status = 'expired';
$lic->save();
