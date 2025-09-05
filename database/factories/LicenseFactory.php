<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\License>
 */
class LicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'doctor_id'           => Doctor::factory(),
            'state_id'            => State::inRandomOrder()->value('id') ?? State::factory(),
            'license_number'      => strtoupper(fake()->bothify('??#####')),
            'license_type'        => fake()->randomElement(['MD','DO','APRN','PA']),
            'issued_date'         => fake()->dateTimeBetween('-8 years','-1 year'),
            'expiration_date'     => fake()->dateTimeBetween('+1 month','+2 years'),
            'active_license_link' => fake()->url(),
            'dea_number'          => fake()->optional()->bothify('AB#######'),
            'notes'               => fake()->optional()->sentence(),
            'cost'                => fake()->optional()->randomFloat(2,50,1200),
            'mal_praxis_required' => fake()->boolean(30),
            'forms'               => ['app'=>'tebra','ids'=>[fake()->uuid()]],
            'need_physical_office'=> fake()->boolean(10),
            'insurance'           => ['carrier'=>'MedPro','policy'=>fake()->bothify('POL-####')],
            'status'              => fake()->randomElement(['active','pending','expired']),
        ];
    }

}
