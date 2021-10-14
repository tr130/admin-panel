<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_date' => $this->faker->dateTimeThisDecade(),
            'annual_gross' => $this->faker->numberBetween(12000, 200000),
            'contracted_hours' => $this->faker->numberBetween(1, 192),
            'overtime_rate' => $this->faker->randomFloat(1, 1, 4),
        ];
    }
}
