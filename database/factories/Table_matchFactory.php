<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table_match>
 */
class Table_matchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organisateur_id' => fake()->numberBetween(1, 10),
            'match_date' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'lieu' => fake()->address(),
            'niveau' => fake()->numberBetween(1, 5),
            'categorie' => fake()->randomElement(['male', 'female']),
            'ligue' => 'ligue 1',
            'description' => fake()->paragraph(2),
        ];
    }
}
