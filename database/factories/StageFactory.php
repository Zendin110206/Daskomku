<?php
// database/factories/StageFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stage>
 */
class StageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Administrasi',
                'Tes Tulis dan koding',
                'Wawancara',
                'TuCil',
                'Teaching',
                'Levelling'
            ]),
        ];
    }
}
