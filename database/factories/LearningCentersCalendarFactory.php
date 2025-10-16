<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LearningCenter;
use App\Models\Calendar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningCenterCalendar>
 */
class LearningCentersCalendarFactory extends Factory
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
            'calendar_id' => Calendar::inRandomOrder()->first()->id,
            'open_time' => fake()->time('H:i', fake()->dateTimeBetween('06:00', '08:00')),
            'close_time' => fake()->time('H:i', fake()->dateTimeBetween('12:00', '21:00')),
        ];
    }
}
