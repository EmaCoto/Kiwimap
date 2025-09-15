<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseFactory extends Factory
{
    public function definition(): array
    {
        // Elige status con pesos 60/20/20
        $status = $this->faker->randomElement([
            ...array_fill(0, 6, 'active'),
            ...array_fill(0, 2, 'pending'),
            ...array_fill(0, 2, 'expired'),
        ]);

        // Genera fechas coherentes con el status
        [$issued, $expires] = match ($status) {
            'active'  => $this->datesActive(),
            'pending' => $this->datesPending(),
            'expired' => $this->datesExpired(),
            default   => $this->datesActive(),
        };

        // Enlaces: activo para active/pending, expirado para expired
        $hasActiveLink      = in_array($status, ['active','pending']);
        $expiredLicenseLink = $status === 'expired'
            ? $this->faker->url()
            : null;

        return [
            // relaciones
            'doctor_id'           => Doctor::inRandomOrder()->value('id') ?? Doctor::factory(),
            'state_id'            => State::inRandomOrder()->value('id')   ?? State::factory(),

            // fechas
            'issued_date'         => $issued?->format('Y-m-d'),
            'expiration_date'     => $expires?->format('Y-m-d'),

            // flags & metadatos
            'has_active_link'     => $hasActiveLink,
            'expired_license_link'=> $expiredLicenseLink,

            'notes'               => $this->faker->optional()->sentence(),
            'cost'                => $this->faker->optional()->randomFloat(2, 100, 900),
            'mal_praxis_required' => $this->faker->boolean(30),
            'forms'               => $this->faker->optional()->randomElement([
                ['app'=>'tebra','ids'=>[$this->faker->uuid()]],
                null,
            ]),
            'need_physical_office'=> $this->faker->boolean(20),
            'insurance'           => $this->faker->optional()->randomElement([
                ['carrier'=>'MedPro','policy'=>'POL-'.mt_rand(1000,9999)],
                null,
            ]),

            'status'              => $status,
        ];
    }

    // ===== Helpers de fechas por status =====

    /** active: emitida en últimos 3 años, expira entre +3 y +24 meses */
    protected function datesActive(): array
    {
        $issued  = $this->faker->dateTimeBetween('-3 years', 'now');
        $months  = $this->faker->numberBetween(3, 24);
        $expires = (clone $issued)->modify("+{$months} months");

        // si aún quedó en pasado (por issued muy antiguo), empuja a futuro
        if ($expires < now()) {
            $expires = now()->addMonths($this->faker->numberBetween(3, 24));
        }
        return [$issued, $expires];
    }

    /** pending: expira pronto, entre +1 y +3 meses (renovación en curso) */
    protected function datesPending(): array
    {
        $issued  = $this->faker->dateTimeBetween('-2 years', 'now');
        $days    = $this->faker->numberBetween(30, 90); // 1 a 3 meses aprox
        $expires = now()->addDays($days);
        return [$issued, $expires];
    }

    /** expired: expirada entre hace 1 día y 24 meses */
    protected function datesExpired(): array
    {
        $expires = $this->faker->dateTimeBetween('-24 months', '-1 day');
        // emitida antes de expirar (entre 6-36 meses antes)
        $issued  = (clone $expires)->modify('-'.$this->faker->numberBetween(6, 36).' months');
        return [$issued, $expires];
    }

    // ===== States de fábrica para uso explícito =====

    public function active(): self
    {
        return $this->state(function () {
            [$issued, $expires] = $this->datesActive();
            return [
                'status'              => 'active',
                'issued_date'         => $issued?->format('Y-m-d'),
                'expiration_date'     => $expires?->format('Y-m-d'),
                'has_active_link'     => true,
                'expired_license_link'=> null,
            ];
        });
    }

    public function pending(): self
    {
        return $this->state(function () {
            [$issued, $expires] = $this->datesPending();
            return [
                'status'              => 'pending',
                'issued_date'         => $issued?->format('Y-m-d'),
                'expiration_date'     => $expires?->format('Y-m-d'),
                'has_active_link'     => true,
                'expired_license_link'=> null,
            ];
        });
    }

    public function expired(): self
    {
        return $this->state(function () {
            [$issued, $expires] = $this->datesExpired();
            return [
                'status'              => 'expired',
                'issued_date'         => $issued?->format('Y-m-d'),
                'expiration_date'     => $expires?->format('Y-m-d'),
                'has_active_link'     => false,
                'expired_license_link'=> $this->faker->url(),
            ];
        });
    }
}
