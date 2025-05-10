<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = 'Perfume - ' . $this->faker->unique()->word();
        $slug = Str::slug($name) . '-' . Str::random(6); // ensures uniqueness

        return [
            'name' => $name,
            'slug' => strtolower($slug),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'discount_percentage' => $this->faker->numberBetween(10, 90),
            'images' => array_map(fn($i) => 'https://placehold.co/600x400?text=Image+' . ($i + 1), range(0, 4)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
