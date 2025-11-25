<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rencontre>
 */
class RencontreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'equipe_domicile_id' => \App\Models\Equipe::factory(),
            'equipe_exterieur_id' => \App\Models\Equipe::factory(),
            'score_domicile' => $this->faker->numberBetween(0, 20),
            'score_exterieur' => $this->faker->numberBetween(0, 20),
            'date' => $this->faker->date(),
            'heure' => $this->faker->time(),
            'categorie' => 'Senior', // Default, should be overridden
        ];
    }
}
