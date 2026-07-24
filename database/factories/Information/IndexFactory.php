<?php

namespace Database\Factories\Information;

use App\Models\Information\Index;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Index>
 */
class IndexFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'information' => fake()->text(100),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
