<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Devoir;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devoir>
 */
class DevoirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->unique()->sentence,
            'description' => $this->faker->paragraph,
            'date_creation' => $this->faker->date,
            'in_classe' => $this->faker->numberBetween(1, 5),
            'in_creature' => $this->faker->numberBetween(1, 10),
        ];
    }
}