<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\Salary;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
    protected $model = Salary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->word,
            'salary' => $this->faker->regexify('[A-Za-z0-9]{16}'),
            'position_id' => Position::factory(),
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_dt' => now(),
        ];
    }
}
