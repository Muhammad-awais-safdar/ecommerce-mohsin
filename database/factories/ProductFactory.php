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
        $name = $this->faker->unique()->words(3, true);
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'brand' => $this->faker->company,
            'slug' => $slug,
            'description' => $this->faker->paragraph,
            'discount_percentage' => $this->faker->optional()->numberBetween(5, 50),
            'price' => $this->faker->randomFloat(2, 10, 999),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'sku' => $this->faker->unique()->bothify('##########'),
            'images' => json_encode([
                $this->faker->imageUrl(640, 480, 'products', true),
                $this->faker->imageUrl(640, 480, 'products', true),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Create related ProductDetail
            $product->productDetail()->create([
                'short_description' => $this->faker->sentence,
                'long_description' => $this->faker->paragraphs(3, true),
                'gender' => $this->faker->randomElement(['male', 'female', 'unisex']),
                'fragrance_type' => $this->faker->randomElement(['citrus', 'woody', 'floral', 'spicy']),
                'concentration' => $this->faker->randomElement(['EDP', 'EDT', 'Parfum']),
                'top_notes' => $this->faker->words(3, true),
                'middle_notes' => $this->faker->words(3, true),
                'base_notes' => $this->faker->words(3, true),
                'volume_ml' => $this->faker->randomElement([50, 75, 100, 150]),
                'longevity_hours' => $this->faker->numberBetween(4, 12),
                'country_of_origin' => $this->faker->country,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create related ProductStock
            $product->productStock()->create([
                'quantity' => $this->faker->numberBetween(0, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
