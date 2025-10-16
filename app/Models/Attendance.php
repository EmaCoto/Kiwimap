<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','work_date','timezone',
        'clock_in','break1_start','break1_end',
        'break2_start','break2_end',
        'lunch_start','lunch_end',
        'clock_out','status',
    ];

    protected $casts = [
        'work_date'    => 'date',
        'clock_in'     => 'datetime',
        'break1_start' => 'datetime',
        'break1_end'   => 'datetime',
        'break2_start' => 'datetime',
        'break2_end'   => 'datetime',
        'lunch_start'  => 'datetime',
        'lunch_end'    => 'datetime',
        'clock_out'    => 'datetime',
    ];

    /**
     * Segundos trabajados del día = (salida - entrada) - almuerzo.
     * - Si hay lunch_start y lunch_end, descuentan SU duración, con tope de 1h.
     * - Si no hay almuerzo marcado, no se descuenta nada.
     * - Calculado usando la TZ del registro para evitar desfases.
     */
    public function workedSeconds(): int
    {
        if (!$this->clock_in || !$this->clock_out) {
            return 0;
        }

        $tz  = $this->timezone ?: config('app.timezone', 'UTC');
        $in  = Carbon::parse($this->clock_in,  $tz);
        $out = Carbon::parse($this->clock_out, $tz);

        $total = max(0, $in->diffInSeconds($out));

        $deduct = 0;
        if ($this->lunch_start && $this->lunch_end) {
            $ls = Carbon::parse($this->lunch_start, $tz);
            $le = Carbon::parse($this->lunch_end,   $tz);
            $deduct = min(3600, max(0, $ls->diffInSeconds($le))); // tope 1h
        }

        return max(0, $total - $deduct);
    }

    /** Versión en HH:MM */
    public function workedHhMm(): string
    {
        return self::hm($this->workedSeconds());
    }

    /** Accessor: $attendance->worked_seconds */
    public function getWorkedSecondsAttribute(): int
    {
        return $this->workedSeconds();
    }

    /** Accessor: $attendance->worked_hhmm */
    public function getWorkedHhmmAttribute(): string
    {
        return $this->workedHhMm();
    }

    /** Utilidad HH:MM */
    public static function hm(int $seconds): string
    {
        $h = intdiv($seconds, 3600);
        $m = intdiv($seconds % 3600, 60);
        return sprintf('%02d:%02d', $h, $m);
    }

    protected function serializeDate(\DateTimeInterface $date): string
    {
        // Evita conversiones de timezone y muestra exactamente la hora guardada
        return $date->format('Y-m-d H:i:s');
    }

    public function getRawTime($column)
    {
        $value = $this->getRawOriginal($column);
        return $value ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value) : null;
    }

}
