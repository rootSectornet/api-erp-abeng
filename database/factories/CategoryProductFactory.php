<?php
namespace Database\Factories;

use App\Models\CategoryProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryProductFactory extends Factory
{
    protected $model = CategoryProduct::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'is_active' => $this->faker->boolean
        ];
    }
}
