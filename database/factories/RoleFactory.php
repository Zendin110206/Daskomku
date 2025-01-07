<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word,          // Unique random word
            'description' => fake()->sentence,         // Random sentence
            'avatar_url' => fake()->imageUrl(200, 200, 'avatar'), // Random avatar URL
            'photo_character_url' => fake()->imageUrl(300, 300, 'character'), // Random character image URL
            'photo_profile_url' => fake()->imageUrl(150, 150, 'profile'), // Random profile image URL
            'quota' => fake()->numberBetween(1, 50),   // Random number for quota
        ];
    }
}
