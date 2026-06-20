<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement([
            ...array_fill(0, 6, 'active'),
            ...array_fill(0, 2, 'renovation'),
            ...array_fill(0, 2, 'expired'),
        ]);

        [$issued, $expires] = match ($status) {
            'active' => $this->datesActive(),
            'renovation' => $this->datesRenovation(),
            'expired' => $this->datesExpired(),
            default => $this->datesActive(),
        };

        $hasActiveLink = in_array($status, ['active', 'renovation'], true);
        $expiredLicenseLink = $status === 'expired'
            ? $this->faker->url()
            : null;

        return [
            'doctor_id' => Doctor::inRandomOrder()->value('id') ?? Doctor::factory(),
            'state_id' => State::inRandomOrder()->value('id') ?? State::factory(),
            'issued_date' => $issued?->format('Y-m-d'),
            'expiration_date' => $expires?->format('Y-m-d'),
            'has_active_link' => $hasActiveLink,
            'expired_license_link' => $expiredLicenseLink,
            'notes' => $this->faker->optional()->sentence(),
            'cost' => $this->faker->optional()->randomFloat(2, 100, 900),
            'mal_praxis_required' => $this->faker->boolean(30),
            'forms' => $this->faker->optional()->randomElement([
                ['app' => 'tebra', 'ids' => [$this->faker->uuid()]],
                null,
            ]),
            'need_physical_office' => $this->faker->boolean(20),
            'insurance' => $this->faker->optional()->randomElement([
                ['carrier' => 'MedPro', 'policy' => 'POL-'.mt_rand(1000, 9999)],
                null,
            ]),
            'status' => $status,
        ];
    }

    protected function datesActive(): array
    {
        $issued = $this->faker->dateTimeBetween('-3 years', 'now');
        $months = $this->faker->numberBetween(3, 24);
        $expires = (clone $issued)->modify("+{$months} months");

        if ($expires < now()) {
            $expires = now()->addMonths($this->faker->numberBetween(3, 24));
        }

        return [$issued, $expires];
    }

    protected function datesRenovation(): array
    {
        $issued = $this->faker->dateTimeBetween('-2 years', 'now');
        $days = $this->faker->numberBetween(30, 90);
        $expires = now()->addDays($days);

        return [$issued, $expires];
    }

    protected function datesExpired(): array
    {
        $expires = $this->faker->dateTimeBetween('-24 months', '-1 day');
        $issued = (clone $expires)->modify('-'.$this->faker->numberBetween(6, 36).' months');

        return [$issued, $expires];
    }

    public function active(): self
    {
        return $this->state(function () {
            [$issued, $expires] = $this->datesActive();

            return [
                'status' => 'active',
                'issued_date' => $issued?->format('Y-m-d'),
                'expiration_date' => $expires?->format('Y-m-d'),
                'has_active_link' => true,
                'expired_license_link' => null,
            ];
        });
    }

    public function renovation(): self
    {
        return $this->state(function () {
            [$issued, $expires] = $this->datesRenovation();

            return [
                'status' => 'renovation',
                'issued_date' => $issued?->format('Y-m-d'),
                'expiration_date' => $expires?->format('Y-m-d'),
                'has_active_link' => true,
                'expired_license_link' => null,
            ];
        });
    }

    public function pending(): self
    {
        return $this->renovation();
    }

    public function expired(): self
    {
        return $this->state(function () {
            [$issued, $expires] = $this->datesExpired();

            return [
                'status' => 'expired',
                'issued_date' => $issued?->format('Y-m-d'),
                'expiration_date' => $expires?->format('Y-m-d'),
                'has_active_link' => false,
                'expired_license_link' => $this->faker->url(),
            ];
        });
    }
}
