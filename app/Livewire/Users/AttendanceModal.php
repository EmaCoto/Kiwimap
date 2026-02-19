<?php

namespace App\Livewire\Users;

use App\Models\Attendance;
use App\Models\MonthlyAttendanceSummary;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AttendanceModal extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    // Usa un pageName propio para no chocar con otras paginaciones
    protected string $paginationTheme = 'tailwind';
    protected $queryString = []; // evita que la paginación se pegue en la URL

    public ?User $user = null;
    public bool $open = false;

    public string $todayHhMm = '00:00';
    public string $weekHhMm  = '00:00';
    public string $monthHhMm = '00:00';
    public string $yearHhMm  = '00:00';
    public string $tzLabel   = 'UTC';
    public string $todayStr  = '';

    /** Tabla */
    public array $rows = [];
    public int $perPage = 10;   // 👈 tamaño de página
    public string $pageName = 'att_page'; // 👈 nombre de paginación interno

    /** Historial mensual (últimos 12) */
    public array $history = []; // [['month' => '2025-10-01', 'hhmm' => '123:45'], ...]

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

        // --- Tabla con paginación (últimos 90 días para dar margen) ---
        $from = $now->copy()->subDays(90)->toDateString();
        $to   = $today;

        $paginator = Attendance::where('user_id', $this->user->id)
            ->whereBetween('work_date', [$from, $to])
            ->orderByDesc('work_date')
            ->paginate($this->perPage, pageName: $this->pageName);

        // tz de referencia
        $first = $paginator->firstItem() ? optional($paginator->items()[0]) : null;
        if ($first) {
            $this->tzLabel = $first->timezone ?? config('app.timezone','UTC');
        } else {
            // fallback
            $this->tzLabel = config('app.timezone','UTC');
        }
        $this->todayStr = Carbon::today($this->tzLabel)->toDateString();

        // filas tabla (sin convertir zonas; mostramos "crudo" como se guardó)
        $this->rows = collect($paginator->items())->map(function (Attendance $a) {
            $get = function (string $col) use ($a) {
                // Si tienes getRawTime($col) úsalo, si no, toma el atributo tal cual
                $dt = method_exists($a, 'getRawTime') ? $a->getRawTime($col) : $a->{$col};
                return $dt ? $dt->format('H:i:s') : null;
            };

            return [
                'overtime' => $a->overtime_hhmm,
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

        // --- Totales día/semana/mes/año ---
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

        $yearStart = $now->copy()->startOfYear()->toDateString();
        $yearEnd   = $now->copy()->endOfYear()->toDateString();
        $yearSec   = Attendance::where('user_id', $this->user->id)
            ->whereBetween('work_date', [$yearStart, $yearEnd])
            ->get()
            ->sum(fn($a) => $a->worked_seconds);

        // Snapshot de mes actual -> para el historial
        MonthlyAttendanceSummary::updateOrCreate(
            ['user_id' => $this->user->id, 'month' => $monthStart],
            ['timezone' => $this->tzLabel, 'total_seconds' => $monthSec]
        );

        // Historial últimos 12 meses (si no existe registro, calcula al vuelo)
        $this->history = $this->buildHistory($now, 12);

        // set UI
        $this->todayHhMm = $this->fmt($todaySec);
        $this->weekHhMm  = $this->fmt($weekSec);
        $this->monthHhMm = $this->fmt($monthSec);
        $this->yearHhMm  = $this->fmt($yearSec);



        // Guarda el paginator en el estado para la vista (sin exponer todo)
        // Livewire te permite devolverlo directo a la vista:
        $this->setPaginatorInstance($paginator);
    }

    /** Guarda internamente el paginator para la vista */
    private \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator;

    private function setPaginatorInstance(\Illuminate\Contracts\Pagination\LengthAwarePaginator $p): void
    {
        $this->paginator = $p;
    }

    /** Historial: intenta leer summaries; si falta alguno, calcula de Attendance */
    private function buildHistory(Carbon $now, int $monthsBack = 12): array
    {
        $items = [];
        for ($i = 0; $i < $monthsBack; $i++) {
            $mStart = $now->copy()->startOfMonth()->subMonths($i)->toDateString();
            $mEnd   = $now->copy()->startOfMonth()->subMonths($i)->endOfMonth()->toDateString();

            $summary = MonthlyAttendanceSummary::where('user_id', $this->user->id)
                ->whereDate('month', $mStart)
                ->first();

            if ($summary) {
                $sec = (int) $summary->total_seconds;
            } else {
                $sec = Attendance::where('user_id', $this->user->id)
                    ->whereBetween('work_date', [$mStart, $mEnd])
                    ->get()
                    ->sum(fn($a) => $a->worked_seconds);
            }

            $items[] = [
                'month' => $mStart,      // YYYY-MM-01
                'hhmm'  => $this->fmt($sec),
            ];
        }

        return $items;
    }

    public function previous(): void
    {
        $this->previousPage($this->pageName);
        $this->loadReport();
    }

    public function next(): void
    {
        $this->nextPage($this->pageName);
        $this->loadReport();
    }

    public function render()
    {
        // Pasa el paginator a la vista para mostrar info de páginas
        return view('livewire.users.attendance-modal', [
            'paginator' => $this->paginator ?? null,
        ]);
    }
}
