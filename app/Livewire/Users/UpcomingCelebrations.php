<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterface;
use Livewire\Attributes\Url;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UpcomingCelebrations extends Component
{
    use AuthorizesRequests;

    #[Url(as: 'month')] public ?int $month = null;   // 1..12 (filtro de mes mostrado en el listado principal)
    #[Url(as: 'type')]  public string $type = 'all'; // all|birthday|kiwimed|group
    public string $tz;

    /** Próximos del mes actual (independiente del filtro de mes y tipo) */
    public array $upcomingCurrentMonth = []; // list<array{user:User, which:string, date:CarbonInterface}>

    /** Items del mes mostrado (mes seleccionado o mes actual si null) */
    public array $monthItems = []; // list<array{user:User, which:string, date:CarbonInterface, is_past:bool}>

    public function mount(): void
    {
        // $this->authorize('viewAny', User::class);
        $this->tz = config('app.timezone', 'UTC');

        if ($this->month !== null) {
            $this->month = max(1, min(12, (int) $this->month));
        }

        $allowed = ['all','birthday','kiwimed','group'];
        if (!in_array($this->type, $allowed, true)) {
            $this->type = 'all';
        }
    }

    public function updatedMonth($val): void
    {
        $this->month = ($val !== null && $val !== '') ? max(1, min(12, (int) $val)) : null;
    }

    public function updatedType($val): void
    {
        $allowed = ['all','birthday','kiwimed','group'];
        $this->type = in_array($val, $allowed, true) ? $val : 'all';
    }

    public function clearFilters(): void
    {
        $this->month = null;
        $this->type  = 'all';
    }

    /** Descarga en un CSV UTF-8 compatible con Excel los hitos del filtro visible. */
    public function exportExcel(): StreamedResponse
    {
        $this->buildLists();

        $shownMonth = $this->month ?: (int) Carbon::now($this->tz)->format('n');
        $filename = sprintf(
            'cumpleaniversarios-%04d-%02d.csv',
            (int) Carbon::now($this->tz)->format('Y'),
            $shownMonth
        );

        $rows = collect($this->monthItems)->map(static function (array $row): array {
            return [
                $row['user']->name,
                User::humanMilestoneLabel($row['which']),
                $row['date']->format('d/m/Y'),
            ];
        })->all();

        return response()->streamDownload(function () use ($rows): void {
            $output = fopen('php://output', 'wb');

            // BOM para que Excel reconozca correctamente tildes y caracteres UTF-8.
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Nombre', 'Qué está cumpliendo', 'Fecha'], ';');

            foreach ($rows as $row) {
                fputcsv($output, $row, ';');
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /** ========= Helpers de fecha (seguros con CarbonInterface) ========= */

    /**
     * Toma una fecha de la BD (Date/Y-m-d) y devuelve la ocurrencia en el año $year,
     * ajustando Feb 29 si el año no es bisiesto.
     */
    private function occurrenceInYear(?CarbonInterface $dbDate, int $year, string $tz): ?CarbonInterface
    {
        if (!$dbDate) return null;

        $m = (int) $dbDate->copy()->timezone($tz)->format('n');
        $d = (int) $dbDate->copy()->timezone($tz)->format('j');

        // Ajuste para Feb 29
        $daysInMonth = Carbon::create($year, $m, 1, 0, 0, 0, $tz)->daysInMonth;
        $safeDay = min($d, $daysInMonth);

        return Carbon::create($year, $m, $safeDay, 0, 0, 0, $tz);
    }

    /**
     * Devuelve la ocurrencia de un hito (birthday|kiwimed|group) en el año $year.
     */
    private function userMilestoneInYear(User $u, string $which, int $year, string $tz): ?CarbonInterface
    {
        $date = match ($which) {
            'birthday' => $u->birthday ?? null,
            'kiwimed'  => $u->anniversary_kiwimed ?? null,
            'group'    => $u->anniversary_group ?? null,
            default    => null,
        };

        if ($date === null) return null;

        // Normalizamos a Carbon (por si viene como string/Date)
        $dbDate = $date instanceof CarbonInterface ? $date : Carbon::parse($date, $tz);
        return $this->occurrenceInYear($dbDate, $year, $tz);
    }

    private function includeType(string $t): bool
    {
        return $this->type === 'all' || $this->type === $t;
    }

    /**
     * Construye:
     *  - $this->upcomingCurrentMonth: todos los hitos desde HOY hacia delante en el mes actual (todos los tipos).
     *  - $this->monthItems: todos los hitos del mes mostrado (pasados y futuros),
     *                       respetando filtro de tipo y ordenando como se pidió.
     */
    private function buildLists(): void
    {
        $now   = Carbon::now($this->tz);
        $today = Carbon::today($this->tz);

        $currentMonth = (int) $now->format('n');
        $currentYear  = (int) $now->format('Y');

        $shownMonth   = $this->month ?: $currentMonth; // mes visible en el listado
        $shownYear    = $currentYear;                  // siempre trabajamos con el año actual

        $users = User::query()
            ->with('roles:id,name')
            ->where(function($q){
                $q->whereNotNull('birthday')
                  ->orWhereNotNull('anniversary_kiwimed')
                  ->orWhereNotNull('anniversary_group');
            })
            ->get();

        $upcoming = [];   // del mes actual, >= hoy (todos los tipos)
        $monthAll = [];   // del mes mostrado, incluye pasados y futuros, respeta $this->type

        foreach ($users as $u) {
            // --- Mes actual: SIEMPRE todos los tipos, solo >= hoy ---
            foreach (['birthday','kiwimed','group'] as $w) {
                $occ = $this->userMilestoneInYear($u, $w, $currentYear, $this->tz);
                if ($occ && (int) $occ->format('n') === $currentMonth && $occ->greaterThanOrEqualTo($today)) {
                    $upcoming[] = ['user' => $u, 'which' => $w, 'date' => $occ];
                }
            }

            // --- Mes mostrado: respeta filtro de tipo, incluye pasados y futuros ---
            foreach (['birthday','kiwimed','group'] as $w) {
                if (!$this->includeType($w)) continue;

                $occ = $this->userMilestoneInYear($u, $w, $shownYear, $this->tz);
                if ($occ && (int) $occ->format('n') === $shownMonth) {
                    $isPast = $occ->lt($today);
                    $monthAll[] = [
                        'user'    => $u,
                        'which'   => $w,
                        'date'    => $occ,
                        'is_past' => $isPast,
                    ];
                }
            }
        }

        // Ordenamos “Próximos del mes actual”: fecha ascendente (todos juntos, sin agrupar)
        usort($upcoming, fn($a, $b) => $a['date']->timestamp <=> $b['date']->timestamp);
        $this->upcomingCurrentMonth = $upcoming;

        // Orden en listado del mes:
        //  1) futuros y hoy (is_past=false) primero por fecha ascendente
        //  2) pasados (is_past=true) al final por fecha ascendente
        usort($monthAll, function($a, $b) {
            if ($a['is_past'] !== $b['is_past']) {
                return $a['is_past'] <=> $b['is_past']; // false(0) primero, true(1) después
            }
            return $a['date']->timestamp <=> $b['date']->timestamp;
        });
        $this->monthItems = $monthAll;
    }

    public function render()
    {
        $this->buildLists();

        return view('livewire.users.upcoming-celebrations', [
            'monthNames' => [
                1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',
                7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'
            ],
            'shownMonthNum'  => $this->month ?: (int) Carbon::now($this->tz)->format('n'),
            'currentMonthNum'=> (int) Carbon::now($this->tz)->format('n'),
        ]);
    }
}
