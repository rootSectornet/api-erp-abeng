<?php
namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'unit' => $this->faker->randomElement(['kg', 'g', 'oz']),
            'type' => $this->faker->randomElement(['BERAT', 'RINGAN']),
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_dt' => now(),
        ];
    }
}
