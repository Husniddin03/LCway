<?php

namespace Database\Factories;

use App\Models\LearningCentersImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class LearningCentersImageFactory extends Factory
{
    protected $model = LearningCentersImage::class;

    public function definition(): array
    {
        return [
            'learning_centers_id' => \App\Models\LearningCenter::factory(),
            'image' => 'https://picsum.photos/200/200?random=' . rand(1, 1000),
        ];
    }
}
