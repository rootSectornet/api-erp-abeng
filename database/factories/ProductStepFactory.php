<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductStepFactory extends Factory
{
    protected $model = ProductStep::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->sentence,
            'rank' => $this->faker->numberBetween(1, 10),
            'maxDuration' => $this->faker->numberBetween(1, 100),
            'product_id' => Product::factory(),
        ];
    }
}
