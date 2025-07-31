<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(), 
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'image' => $this->faker->imageUrl(640, 480, 'technics', true),
        ];
    }
}
