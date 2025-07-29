<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $buttonTexts = [
            'Shop Now',
            'Buy Now',
            'Learn More',
            'Discover',
            'Explore',
            'Get Yours',
            'Order Today',
            'Limited Time',
            'Don\'t Miss Out',
            'See Details'
        ];

        $titles = [
            'Summer Sale - Up to 50% Off',
            'New Arrivals - Luxury Fragrances',
            'Limited Edition Perfumes',
            'Best Sellers Collection',
            'Gift Sets Available',
            'Free Shipping This Week',
            'Premium Fragrances for Him',
            'Exclusive Women\'s Collection',
            'Designer Perfumes Sale',
            'Holiday Special Offers'
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'product_id' => $this->faker->boolean(70) ? Product::factory() : null, // 70% chance of having a product
            'custom_image' => $this->faker->boolean(30) ? 'ads/sample-ad-' . $this->faker->numberBetween(1, 5) . '.jpg' : null, // 30% chance of custom image
            'button_text' => $this->faker->randomElement($buttonTexts),
            'button_link' => $this->faker->randomElement([
                '/shop',
                '/product/luxury-perfume-sample',
                'https://example.com/special-offer',
                '/contact',
                '/about'
            ]),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'views' => $this->faker->numberBetween(0, 10000),
            'clicks' => function (array $attributes) {
                // Clicks should be lower than views and realistic CTR
                $views = $attributes['views'];
                $maxClicks = max(1, (int)($views * 0.1)); // Max 10% CTR
                return $this->faker->numberBetween(0, $maxClicks);
            },
            'expires_at' => $this->faker->boolean(60) 
                ? $this->faker->dateTimeBetween('now', '+6 months')
                : null, // 60% chance of having expiration date
        ];
    }

    /**
     * Create an active ad
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'expires_at' => $this->faker->dateTimeBetween('+1 day', '+6 months'),
        ]);
    }

    /**
     * Create an inactive ad
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create an expired ad
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'expires_at' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }

    /**
     * Create ad with custom image
     */
    public function withCustomImage(): static
    {
        return $this->state(fn (array $attributes) => [
            'custom_image' => 'ads/custom-ad-' . $this->faker->numberBetween(1, 10) . '.jpg',
            'product_id' => null, // Remove product when using custom image
        ]);
    }

    /**
     * Create ad with linked product
     */
    public function withProduct(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_id' => Product::factory(),
            'custom_image' => null, // Remove custom image when using product
        ]);
    }

    /**
     * Create high-performing ad
     */
    public function highPerforming(): static
    {
        return $this->state(function (array $attributes) {
            $views = $this->faker->numberBetween(5000, 20000);
            $clicks = (int)($views * $this->faker->randomFloat(2, 0.05, 0.15)); // 5-15% CTR
            
            return [
                'views' => $views,
                'clicks' => $clicks,
                'is_active' => true,
                'expires_at' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            ];
        });
    }

    /**
     * Create low-performing ad
     */
    public function lowPerforming(): static
    {
        return $this->state(function (array $attributes) {
            $views = $this->faker->numberBetween(1000, 5000);
            $clicks = (int)($views * $this->faker->randomFloat(3, 0.001, 0.02)); // 0.1-2% CTR
            
            return [
                'views' => $views,
                'clicks' => $clicks,
                'is_active' => true,
                'expires_at' => $this->faker->dateTimeBetween('+1 week', '+3 months'),
            ];
        });
    }
}