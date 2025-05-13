<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Review;
use App\Models\User;
use Database\Seeders\ProductSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // OrderSeeder::class,
            ProductSeeder::class,
            SeoSeeder::class,
            ThemeSettingSeeder::class,
        ]);
        Order::factory()->count(50)->create();

        Product::factory(30)->create();
        Review::factory()->count(200)->create();
    }
}
