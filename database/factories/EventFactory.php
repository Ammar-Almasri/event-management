<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id, // Random user ID
            'name' => $this->faker->word . ' Event', // Random event name
            'description' => $this->faker->paragraph, // Random event description
            'start_time' => $this->faker->dateTimeBetween('now', '+1 month'), // Random start time (within the next month)
            'end_time' => $this->faker->dateTimeBetween('+1 month', '+2 months'), // Random end time (within the next 1-2 months)
        ];
    }
}
