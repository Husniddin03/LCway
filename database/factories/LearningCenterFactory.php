<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningCenter>
 */
class LearningCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'logo' => 'https://picsum.photos/200/200?random=' . rand(1, 1000),
            'name' => fake()->company(),
            'type' => fake()->randomElement(['O‘quv markaz', 'Kurs', 'Akademiya']),
            'about' => fake()->paragraph(15),
            'province' => fake()->state(),
            'region' => fake()->city(),
            'address' => fake()->address(),
            'location' => fake()->latitude() . ',' . fake()->longitude(),
            'users_id' => User::factory(),
            'student_count' => fake()->numberBetween(10, 500),
        ];
    }
}
