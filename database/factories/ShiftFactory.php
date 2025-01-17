<?php
// database/factories/ShiftFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    public function definition(): array
    {
        return [
            'shift_no' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'time_start' => $this->faker->time(),
            'time_end' => $this->faker->time(),
            'kuota' => $this->faker->numberBetween(1, 50),
        ];
    }
}

