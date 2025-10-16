<?php

namespace App\Livewire\Users;

use App\Models\Attendance;
use App\Models\MonthlyAttendanceSummary;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendanceModal extends Component
{
    use AuthorizesRequests;

    public ?User $user = null;
    public bool $open = false;

    public string $todayHhMm = '00:00';
    public string $weekHhMm  = '00:00';
    public string $monthHhMm = '00:00';
    public string $tzLabel   = 'UTC';
    public string $todayStr  = '';
    public array $rows = [];

    #[On('open-attendance')]
    public function open(int $userId): void
    {
        $this->user = User::findOrFail($userId);
        $this->authorize('view', $this->user);

        $this->loadReport();
        $this->open = true;
    }

    public function close(): void { $this->open = false; }

    private function fmt(int $sec): string
    {
        $h = intdiv($sec, 3600);
        $m = intdiv($sec % 3600, 60);
        return sprintf('%02d:%02d', $h, $m);
    }

    private function loadReport(): void
    {
        $now   = Carbon::now();
        $today = $now->toDateString();

        // últimos 30 días para la tabla
        $from = $now->copy()->subDays(30)->toDateString();
        $to   = $today;

        $atts = Attendance::where('user_id', $this->user->id)
            ->whereBetween('work_date', [$from, $to])
            ->orderByDesc('work_date')
            ->get();

        $this->tzLabel  = $atts->first()->timezone ?? config('app.timezone','UTC');
        $this->todayStr = Carbon::today($this->tzLabel)->toDateString();

        // filas para la tabla (usa los accessors)
        $this->rows = $atts->map(function (Attendance $a) {
            $get = fn($col) => $a->getRawTime($col)?->format('H:i:s');

            return [
                'date'   => optional($a->work_date)->toDateString(),
                'in'     => $get('clock_in'),
                'b1s'    => $get('break1_start'),
                'b1e'    => $get('break1_end'),
                'b2s'    => $get('break2_start'),
                'b2e'    => $get('break2_end'),
                'ls'     => $get('lunch_start'),
                'le'     => $get('lunch_end'),
                'out'    => $get('clock_out'),
                'worked' => $a->worked_hhmm,
                'status' => $a->status,
            ];
        })->toArray();


        // Totales (misma regla del modelo)
        $todaySec = Attendance::where('user_id', $this->user->id)
            ->whereDate('work_date', $today)
            ->get()
            ->sum(fn($a) => $a->worked_seconds);

        $weekStart = $now->copy()->startOfWeek()->toDateString();
        $weekEnd   = $now->copy()->endOfWeek()->toDateString();
        $weekSec   = Attendance::where('user_id', $this->user->id)
            ->whereBetween('work_date', [$weekStart, $weekEnd])
            ->get()
            ->sum(fn($a) => $a->worked_seconds);

        $monthStart = $now->copy()->startOfMonth()->toDateString();
        $monthEnd   = $now->copy()->endOfMonth()->toDateString();
        $monthSec   = Attendance::where('user_id', $this->user->id)
            ->whereBetween('work_date', [$monthStart, $monthEnd])
            ->get()
            ->sum(fn($a) => $a->worked_seconds);

        // (opcional) snapshot de mes actual en tu tabla summary
        MonthlyAttendanceSummary::updateOrCreate(
            ['user_id' => $this->user->id, 'month' => $monthStart],
            ['timezone' => $this->tzLabel, 'total_seconds' => $monthSec]
        );

        $this->todayHhMm = $this->fmt($todaySec);
        $this->weekHhMm  = $this->fmt($weekSec);
        $this->monthHhMm = $this->fmt($monthSec);
    }

    public function render() { return view('livewire.users.attendance-modal'); }
}