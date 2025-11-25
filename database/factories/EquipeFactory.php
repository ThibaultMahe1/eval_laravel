<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipe>
 */
class EquipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ville' => $this->faker->city(),
            'categorie' => $this->faker->randomElement(['Senior', 'Junior', 'Cadet']),
            'nb_licencies' => 0,
            'championnat' => 'Ligue 1',
        ];
    }
}
