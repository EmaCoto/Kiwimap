<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name','email','password','avatar_path',
        'employee_number',
        'has_id_badge',
        'birthday',
        'anniversary_kiwimed',
        'anniversary_group',
        'country_code',
        'spruce_number',
        'crecer_number',
    ];

    protected $hidden = ['password','remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'password'            => 'hashed',
            'has_id_badge'        => 'boolean',
            'birthday'            => 'date',
            'anniversary_kiwimed' => 'date',
            'anniversary_group'   => 'date',
        ];
    }

    public function primaryRoleName(): string
    {
        $r = $this->roles()->first();
        return $r ? ucfirst($r->name) : 'Ã¢â‚¬â€';
    }

    /** Devuelve Carbon con la PRÃƒâ€œXIMA ocurrencia (desde hoy) para una fecha MM-DD (ignora aÃƒÂ±o) */
        public function nextOccurrenceOf(?string $date, ?string $tz = null): ?Carbon
    {
        if (!$date) return null;

        $tz = $tz ?: config('app.timezone', 'UTC');
        // Acepta 'YYYY-MM-DD' o 'MM-DD'
        $base = Carbon::parse($date, $tz);
        $now  = Carbon::now($tz);

        $cand = Carbon::createSafe(
            $now->year,
            (int) $base->format('m'),
            (int) $base->format('d'),
            0, 0, 0,
            $tz
        );

        if ($cand->isBefore($now->startOfDay())) {
            $cand->addYear();
        }
        return $cand;
    }

    /** PrÃƒÂ³ximos */
    public function nextBirthday(?string $tz = null): ?Carbon
    {
        return $this->nextOccurrenceOf($this->birthday, $tz);
    }

    public function nextAnnivKiwimed(?string $tz = null): ?Carbon
    {
        return $this->nextOccurrenceOf($this->anniversary_kiwimed, $tz);
    }

    public function nextAnnivGroup(?string $tz = null): ?Carbon
    {
        return $this->nextOccurrenceOf($this->anniversary_group, $tz);
    }

    /** URL de bandera a partir del country_code si no tienes country_flag_url persistido */
    public function getCountryFlagUrlAttribute(): ?string
    {
        if (!empty($this->attributes['country_flag_url'])) {
            return $this->attributes['country_flag_url'];
        }
        $code = strtolower((string) ($this->country_code ?? ''));
        return $code ? "https://flagcdn.com/24x18/{$code}.png" : null;
    }

    /** Etiqueta legible del hito */
    public static function humanMilestoneLabel(string $key): string
    {
        return match ($key) {
            'birthday'       => __('Birthday'),
            'kiwimed'        => __('Dr. Kiwimed Anniversary'),
            'group'          => __('Business Group Anniversary'),
            default          => 'Ã¢â‚¬â€',
        };
    }


    // Iniciales para avatar placeholder
    public function initials(): string
    {
        return Str::of($this->name)->explode(' ')->take(2)
            ->map(fn($w) => Str::substr($w,0,1))->implode('');
    }



    // URL del avatar pÃƒÂºblico
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path? Storage::url($this->avatar_path): null;
    }


    // Fechas formateadas Ã¢â‚¬Å“23, diciembre de 2004Ã¢â‚¬Â
    public function formatLongEs(?Carbon $date): ?string
    {
        return $date ? $date->copy()->locale('es')->translatedFormat('j, F \\d\\e Y') : null;
    }

    public function getBirthdayLongAttribute(): ?string
    {
        return $this->formatLongEs($this->birthday);
    }
    public function getAnniversaryKiwimedLongAttribute(): ?string
    {
        return $this->formatLongEs($this->anniversary_kiwimed);
    }
    public function getAnniversaryGroupLongAttribute(): ?string
    {
        return $this->formatLongEs($this->anniversary_group);
    }
}
