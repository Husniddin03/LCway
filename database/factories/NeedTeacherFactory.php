<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\LearningCenter;
use App\Models\Subject;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NeedTeacher>
 */
class NeedTeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'learning_center_id' => LearningCenter::factory(),
            'subject_id' => Subject::inRandomOrder()->first()->id
        ];
    }
}
