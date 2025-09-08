<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseFactory extends Factory
{
    public function definition(): array
    {
        $issued = $this->faker->optional()->dateTimeBetween('-3 years', 'now');
        $expires = $issued ? (clone $issued)->modify('+'.mt_rand(6,36).' months') : null;

        return [
            'doctor_id'           => Doctor::factory(),
            'state_id'            => State::inRandomOrder()->value('id') ?? State::factory(),
            'issued_date'         => $issued ? $issued->format('Y-m-d') : null,
            'expiration_date'     => $expires ? $expires->format('Y-m-d') : null,
            'has_active_link'     => $this->faker->boolean(60),
            'expired_license_link'=> null,
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
            'status'              => $this->faker->randomElement(['active','pending','expired']),
        ];
    }
}
