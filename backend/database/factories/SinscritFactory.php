<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classe;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sinscrit>
 */
class SinscritFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'date_inscription' =>$this->faker->date,
           'in_eleve' =>User::factory(),
           'in_classe' => Classe::factory(),
        ];
    }
}