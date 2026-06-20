<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_RENOVATION = 'renovation';
    public const STATUS_EXPIRED = 'expired';
    public const LEGACY_STATUS_PENDING = 'pending';

    protected $fillable = [
        'doctor_id', 'state_id',
        'issued_date', 'expiration_date',
        'has_active_link', 'expired_license_link',
        'notes', 'cost', 'mal_praxis_required', 'forms', 'need_physical_office', 'insurance',
        'status',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiration_date' => 'date',
        'has_active_link' => 'boolean',
        'mal_praxis_required' => 'boolean',
        'need_physical_office' => 'boolean',
        'forms' => 'array',
        'insurance' => 'array',
    ];

    public static function canonicalStatuses(): array
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_RENOVATION,
            self::STATUS_EXPIRED,
        ];
    }

    public static function normalizeStatus(?string $status): ?string
    {
        return $status === self::LEGACY_STATUS_PENDING
            ? self::STATUS_RENOVATION
            : $status;
    }

    public static function databaseStatusesFor(?string $status): array
    {
        return match (self::normalizeStatus($status)) {
            self::STATUS_RENOVATION => [self::STATUS_RENOVATION, self::LEGACY_STATUS_PENDING],
            self::STATUS_ACTIVE => [self::STATUS_ACTIVE],
            self::STATUS_EXPIRED => [self::STATUS_EXPIRED],
            default => array_values(array_filter([self::normalizeStatus($status)])),
        };
    }

    public static function normalizedStatusCaseSql(string $column = 'status'): string
    {
        return "CASE WHEN {$column} = '".self::LEGACY_STATUS_PENDING."' THEN '".self::STATUS_RENOVATION."' ELSE {$column} END";
    }

    public function getNormalizedStatusAttribute(): ?string
    {
        return self::normalizeStatus($this->status);
    }

    public function scopeVisibleToUser(Builder $query, ?User $user): Builder
    {
        if ($user?->hasRole('Doctor')) {
            $query->whereHas('doctor', fn (Builder $doctorQuery) => $doctorQuery->where('user_id', $user->id));
        }

        return $query;
    }

    public function scopeForStatus(Builder $query, ?string $status): Builder
    {
        $status = self::normalizeStatus($status);

        if (blank($status) || $status === 'all') {
            return $query;
        }

        return $query->whereIn('status', self::databaseStatusesFor($status));
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
