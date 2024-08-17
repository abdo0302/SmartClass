<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Correction;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Correction>
 */
class CorrectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->paragraph(),
            'file' => 'files/' . $this->faker->uuid . '.pdf', 
            'typ_file' => 'application/pdf',
            'id_devoir'=>Devoir::factory()
        ];
    }
}
