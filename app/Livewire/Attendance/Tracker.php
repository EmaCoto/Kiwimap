<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\MonthlyAttendanceSummary;
use Carbon\Carbon;

class Tracker extends Component
{
    public Attendance $attendance;
    public string $tz = '';
    public string $status = 'offline';

    public function mount(): void
    {
        $user = Auth::user();
        $this->tz = config('app.timezone', 'UTC');

        $today = now($this->tz)->toDateString();

        $this->attendance = Attendance::firstOrCreate(
            ['user_id' => $user->id, 'work_date' => $today],
            ['timezone' => $this->tz, 'status' => 'offline']
        );

        $this->status = $this->attendance->status;
    }

    public function setTz(string $tz): void
    {
        $this->tz = $tz ?: config('app.timezone','UTC');
        if ($this->attendance->timezone !== $this->tz) {
            $this->attendance->update(['timezone' => $this->tz]);
        }
    }

    private function nowTz(): \Carbon\Carbon
    {
        return now($this->tz ?: ($this->attendance->timezone ?? config('app.timezone','UTC')));
    }

    /** Jornada cerrada = ya se marcó salida */
    private function isClosed(): bool
    {
        return (bool) $this->attendance->clock_out;
    }

    /** Una sola vez por día y nunca después de salida */
    private function canMark(string $field): bool
    {
        if ($this->isClosed()) return false;
        return is_null($this->attendance->{$field});
    }

    public function clockIn(): void
    {
        if (!$this->canMark('clock_in')) return;

        $this->attendance->update([
            'clock_in' => $this->nowTz(),
            'status'   => 'working',
        ]);
        $this->attendance->refresh();
        $this->status = $this->attendance->status;
    }

    public function break1Start(): void
    {
        if (!$this->canMark('break1_start')) return;

        $this->attendance->update([
            'break1_start' => $this->nowTz(),
            'status'       => 'break1',
        ]);
        $this->attendance->refresh();
        $this->status = $this->attendance->status;
    }

    public function break1End(): void
    {
        if ($this->isClosed()) return;
        if (!$this->attendance->break1_start || !$this->canMark('break1_end')) return;

        $this->attendance->update([
            'break1_end' => $this->nowTz(),
            'status'     => 'working',
        ]);
        $this->attendance->refresh();
        $this->status = $this->attendance->status;
    }

    public function break2Start(): void
    {
        if (!$this->canMark('break2_start')) return;

        $this->attendance->update([
            'break2_start' => $this->nowTz(),
            'status'       => 'break2',
        ]);
        $this->attendance->refresh();
        $this->status = $this->attendance->status;
    }

    public function break2End(): void
    {
        if ($this->isClosed()) return;
        if (!$this->attendance->break2_start || !$this->canMark('break2_end')) return;

        $this->attendance->update([
            'break2_end' => $this->nowTz(),
            'status'     => 'working',
        ]);
        $this->attendance->refresh();
        $this->status = $this->attendance->status;
    }

    public function lunchStart(): void
    {
        if (!$this->canMark('lunch_start')) return;

        $this->attendance->update([
            'lunch_start' => $this->nowTz(),
            'status'      => 'lunch',
        ]);
        $this->attendance->refresh();
        $this->status = $this->attendance->status;
    }

    public function lunchEnd(): void
    {
        if ($this->isClosed()) return;
        if (!$this->attendance->lunch_start || !$this->canMark('lunch_end')) return;

        $this->attendance->update([
            'lunch_end' => $this->nowTz(),
            'status'    => 'working',
        ]);
        $this->attendance->refresh();
        $this->status = $this->attendance->status;
    }

    public function clockOut(): void
    {
        if (!$this->canMark('clock_out')) return;

        $now = $this->nowTz();

        $this->attendance->update([
            'clock_out' => $now,
            'status'    => 'clocked_out',
        ]);
        $this->attendance->refresh();
        $this->status = $this->attendance->status;

        $this->snapshotMonthIfNeeded();
    }

    private function snapshotMonthIfNeeded(): void
    {
        // … (tu lógica existente, sin cambios)
    }

    public function render()
    {
        $a = $this->attendance->fresh();

        return view('livewire.attendance.tracker', [
            'a'         => $a,
            'status'    => $this->status,
            'today'     => $a->work_date?->isoFormat('dddd, D [de] MMMM YYYY'),
            'tz'        => $a->timezone,
            'todayHHMM' => $a->worked_hhmm,
            'closed'    => (bool) $a->clock_out, // <- para deshabilitar botones en la vista
        ]);
    }
}
