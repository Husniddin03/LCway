<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LearningCenter;
use App\Models\User;

class LearningCentersCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'learning_centers_id' => LearningCenter::factory(),
            'users_id' => User::factory(),
            'comment' => $this->faker->sentence(),
        ];
    }
}
