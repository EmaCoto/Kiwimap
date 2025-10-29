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

        // 👇 nuevos campos (ya existentes en DB)
        'employee_number',
        'has_id_badge',
        'birthday',
        'anniversary_kiwimed',
        'anniversary_group',
        'country_code',      // ej: 'us','co','mx'
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

    // Iniciales para avatar placeholder
    public function initials(): string
    {
        return Str::of($this->name)->explode(' ')->take(2)
            ->map(fn($w) => Str::substr($w,0,1))->implode('');
    }

    public function attendances() {
        return $this->hasMany(\App\Models\Attendance::class);
    }

    // URL del avatar público
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? Storage::disk('public')->url($this->avatar_path) : null;
    }

    // URL de bandera (flagcdn). Requiere country_code ISO-3166-1 alpha-2 minúsculas.
    public function getCountryFlagUrlAttribute(): ?string
    {
        if (!$this->country_code) return null;
        $cc = strtolower($this->country_code);
        // 24x18; usa 32x24 si prefieres mayor tamaño
        return "https://flagcdn.com/24x18/{$cc}.png";
    }

    // Fechas formateadas “23, diciembre de 2004”
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
