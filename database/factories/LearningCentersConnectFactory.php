<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LearningCenter;
use App\Models\Connection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningCenterConnect>
 */
class LearningCentersConnectFactory extends Factory
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
            'connection_id' => Connection::inRandomOrder()->first()->id,
            'url' => fake()->url(),
        ];
    }
}
