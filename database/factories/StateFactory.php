<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => ucwords(fake()->unique()->words(2, true)),
            'code' => strtoupper(fake()->unique()->lexify('??')),
            'is_operational' => true,
        ];
    }
}
