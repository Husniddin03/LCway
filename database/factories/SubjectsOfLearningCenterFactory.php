<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LearningCenter;
use App\Models\Subject;
use App\Models\SubjectsOfLearningCenter;

class SubjectsOfLearningCenterFactory extends Factory
{
    protected $model = SubjectsOfLearningCenter::class;

    public function definition(): array
    {
        return [
            'learning_centers_id' => LearningCenter::factory(),
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'price' => fake()->numberBetween(30, 80)*10000,
        ];
    }
}
