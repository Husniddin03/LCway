<?php

namespace Database\Factories;

use App\Models\LearningCenter;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'learning_centers_id' => LearningCenter::factory(),
            'name' => fake()->name(),
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'photo' => 'https://picsum.photos/200/200?random=' . rand(1, 1000),
            'phone' => fake()->phoneNumber(),
            'about' => fake()->paragraph(),
        ];
    }
}
