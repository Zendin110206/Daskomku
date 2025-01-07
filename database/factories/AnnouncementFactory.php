<?php

namespace Database\Factories;

use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'success_message' => fake()->sentence, // Fake success message
            'fail_message' => fake()->sentence,    // Fake fail message
            'link' => fake()->url,                // Random URL or null
            'stage_id' => Stage::factory(),             // Create a stage and use its ID
        ];
    }
}
