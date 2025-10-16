<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Report extends Component
{
    use AuthorizesRequests;

    public bool $open = false;
    public ?User $user = null;

    public string $tzLabel = 'UTC';
    public string $todayStr = '';
    public string $todayHhMm = '00:00';
    public string $weekHhMm  = '00:00';
    public string $monthHhMm = '00:00';

    /** @var array<int, array<string, string|null>> */
    public array $rows = [];

    #[On('open-attendance')]
    public function open(array $payload): void
    {
        $userId = (int) ($payload['userId'] ?? 0);
        $this->user = User::findOrFail($userId);
        $this->authorize('view', $this->user);

        // Derivar TZ desde el último registro, o fallback al app.timezone
        $last = $this->user->attendances()->latest('work_date')->first();
        $tz = $last->timezone ?? config('app.timezone','UTC');
        $this->tzLabel = $tz;

        $now = now($tz);
        $this->todayStr = $now->toDateString();

        // Rango mes actual
        $startM = $now->copy()->startOfMonth()->toDateString();
        $endM   = $now->copy()->endOfMonth()->toDateString();

        // Trae las asistencias del mes (para la tabla)
        $att = $this->user->attendances()
            ->whereBetween('work_date', [$startM, $endM])
            ->orderByDesc('work_date')
            ->get();

        // Mapea filas (sin tocar tu diseño)
        $fmt = fn($dt, $tz) => $dt ? $dt->clone()->timezone($tz)->format('H:i:s') : null;

        $this->rows = $att->map(function (Attendance $a) use ($fmt) {
            $tz = $a->timezone ?? config('app.timezone','UTC');
            return [
                'date'   => optional($a->work_date)->toDateString(),
                'in'     => $fmt($a->clock_in,     $tz),
                'b1s'    => $fmt($a->break1_start, $tz),
                'b1e'    => $fmt($a->break1_end,   $tz),
                'b2s'    => $fmt($a->break2_start, $tz),
                'b2e'    => $fmt($a->break2_end,   $tz),
                'ls'     => $fmt($a->lunch_start,  $tz),
                'le'     => $fmt($a->lunch_end,    $tz),
                'out'    => $fmt($a->clock_out,    $tz),
                'worked' => Attendance::hm($a->worked_seconds),
                'status' => str_replace('_',' ', ucfirst($a->status)),
            ];
        })->toArray();

        // Totales usando SIEMPRE el mismo cálculo
        $today = $now->toDateString();
        $startW = $now->copy()->startOfWeek()->toDateString();
        $endW   = $now->copy()->endOfWeek()->toDateString();

        $todaySec = $this->user->attendances()
            ->where('work_date', $today)
            ->get()
            ->sum->worked_seconds;

        $weekSec = $this->user->attendances()
            ->whereBetween('work_date', [$startW, $endW])
            ->get()
            ->sum->worked_seconds;

        $monthSec = collect($this->rows)->sum(function ($r) {
            [$h, $m] = array_map('intval', explode(':', $r['worked'] ?? '00:00'));
            return $h * 3600 + $m * 60;
        });

        $this->todayHhMm = Attendance::hm($todaySec);
        $this->weekHhMm  = Attendance::hm($weekSec);
        $this->monthHhMm = Attendance::hm($monthSec);

        $this->open = true;
    }

    public function close(): void
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.attendance.report');
    }
}
