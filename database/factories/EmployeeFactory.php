<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'date_of_birth' => $this->faker->dateTimeBetween('1930-01-01', '2002-01-01'),
            'ni_number' => $this->faker->nino(),
            'SL1' => $this->faker->boolean(),
            'SL2' => $this->faker->boolean(),
            'SL4' => $this->faker->boolean(),
            'SLPG' => $this->faker->boolean(),
        ];
    }
}
