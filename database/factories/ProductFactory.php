<?php
namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'id_category' => \App\Models\CategoryProduct::factory(),
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_dt' => now()
        ];
    }
}

