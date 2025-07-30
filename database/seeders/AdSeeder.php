<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure ads directory exists
        if (!Storage::disk('public')->exists('ads')) {
            Storage::disk('public')->makeDirectory('ads');
        }

        // Create some real sample ads with specific content
        $sampleAds = [
            [
                'title' => 'Summer Fragrance Sale - Up to 50% Off',
                'button_text' => 'Shop Now',
                'button_link' => '/shop',
                'is_active' => true,
                'views' => 2500,
                'clicks' => 180,
                'expires_at' => now()->addMonths(2),
            ],
            [
                'title' => 'New Arrival: Luxury Designer Perfumes',
                'button_text' => 'Discover',
                'button_link' => '/shop',
                'is_active' => true,
                'views' => 1800,
                'clicks' => 95,
                'expires_at' => now()->addMonth(),
            ],
            [
                'title' => 'Free UK Delivery on All Orders',
                'button_text' => 'Learn More',
                'button_link' => '/about',
                'is_active' => true,
                'views' => 3200,
                'clicks' => 240,
                'expires_at' => null, // Never expires
            ],
            [
                'title' => 'Gift Sets Perfect for Any Occasion',
                'button_text' => 'Browse Gifts',
                'button_link' => '/shop',
                'is_active' => true,
                'views' => 1500,
                'clicks' => 75,
                'expires_at' => now()->addWeeks(6),
            ],
            [
                'title' => 'Limited Edition: Exclusive Fragrances',
                'button_text' => 'Get Yours',
                'button_link' => '/shop',
                'is_active' => true,
                'views' => 4200,
                'clicks' => 420, // High CTR example
                'expires_at' => now()->addWeeks(3),
            ],
        ];

        // Create sample ads with linked products if products exist
        foreach ($sampleAds as $index => $adData) {
            $product = Product::inRandomOrder()->first();
            
            Ad::create(array_merge($adData, [
                'product_id' => $product?->id,
                'custom_image' => null, // Will use product image
            ]));
        }

        // Create some ads with custom images (simulated)
        $customImageAds = [
            [
                'title' => 'Black Friday Mega Sale - Don\'t Miss Out!',
                'custom_image' => 'ads/black-friday-banner.jpg',
                'button_text' => 'Shop Sale',
                'button_link' => '/shop',
                'is_active' => true,
                'views' => 8500,
                'clicks' => 680,
                'expires_at' => now()->addDays(7),
                'product_id' => null,
            ],
            [
                'title' => 'Premium Men\'s Collection - Now Available',
                'custom_image' => 'ads/mens-collection-banner.jpg',
                'button_text' => 'Explore',
                'button_link' => '/shop',
                'is_active' => true,
                'views' => 2800,
                'clicks' => 145,
                'expires_at' => now()->addMonths(3),
                'product_id' => null,
            ],
        ];

        foreach ($customImageAds as $adData) {
            Ad::create($adData);
        }

        // Create some inactive/expired ads for testing
        Ad::factory()
            ->inactive()
            ->count(3)
            ->create();

        Ad::factory()
            ->expired()
            ->count(2)
            ->create();

        // Create some high and low performing ads
        Ad::factory()
            ->highPerforming()
            ->count(2)
            ->create();

        Ad::factory()
            ->lowPerforming()
            ->count(3)
            ->create();

        // Create additional random ads using factory
        Ad::factory()
            ->count(10)
            ->create();

        $this->command->info('Created ' . Ad::count() . ' ads successfully!');
        $this->command->info('Active ads: ' . Ad::active()->count());
        $this->command->info('Expired ads: ' . Ad::expired()->count());
        $this->command->info('Ads with products: ' . Ad::whereNotNull('product_id')->count());
        $this->command->info('Ads with custom images: ' . Ad::whereNotNull('custom_image')->count());
    }
}