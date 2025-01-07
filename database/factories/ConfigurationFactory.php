<?php

namespace Database\Factories;

use App\Models\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Configuration>
 */
class ConfigurationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pengumuman_on' => fake()->boolean,       // Random true or false
            'isi_jadwal_on' => fake()->boolean,       // Random true or false
            'role_on' => fake()->boolean,             // Random true or false
            'stage_id' => Stage::factory(),
        ];
    }
}
