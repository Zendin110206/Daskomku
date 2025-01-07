<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tanggal' => fake()->date(),            // Random date
            'waktu' => fake()->time(),             // Random time
            'kuota' => fake()->numberBetween(1, 50), // Random integer between 1 and 50
        ];
    }
}
