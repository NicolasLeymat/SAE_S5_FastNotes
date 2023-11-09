<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Parcours;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Groupe>
 */
class GroupeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->regexify("InS5_[A-C]"),
            'libelle' => fake()->name(),
            'semestre' => fake()->name(),
            'annee' => fake()->numberBetween(1990, 2006),
            'parcours' => fake()->unique()->regexify("[A-Z,a-z]{4}")
        ];
    }
}
