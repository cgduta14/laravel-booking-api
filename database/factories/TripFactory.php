<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakeDate = fake()->dateTimeBetween('-1 months','+1 months');
        $start_date = Carbon::createFromDate($fakeDate);

        return [
            'slug' => fake()->slug(3),
            'title' => fake()->realTextBetween(10,30),
            'description' => fake()->realText(),
            'start_date' => $start_date,
            'end_date' => (clone $start_date)->addDays(random_int(1,14)),
            'location' => fake()->country,
            'price' => fake()->randomFloat(2,10,100)
        ];
    }
}
