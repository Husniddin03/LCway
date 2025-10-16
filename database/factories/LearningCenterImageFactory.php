<?php

namespace Database\Factories;

use App\Models\LearningCentersImage;
use App\Models\LearningCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningCenterImage>
 */
class LearningCenterImageFactory extends Factory
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
            'image' => 'https://picsum.photos/200/200?random=' . rand(1, 1000),
        ];
    }
}
