<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Perfume - ' . $this->faker->word(), // Example: Perfume - Rose
            'description' => $this->faker->paragraph(), // Random description
            'price' => $this->faker->randomFloat(2, 10, 200), // Random price between 10 and 200
            'image' => $this->faker->imageUrl(640, 480, 'fashion', true), // Random image URL
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}