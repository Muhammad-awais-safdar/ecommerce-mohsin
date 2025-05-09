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
            'name' => 'Perfume - ' . $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'discount_percentage' => $this->faker->numberBetween(10, 90),
            'images' => array_map(fn($i) => 'https://placehold.co/600x400?text=Image+' . ($i + 1), range(0, 4)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
