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
      
        
        $this->call(ContactsTableSeeder::class);
        $this->call(EbayVerifiedsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductDetailsTableSeeder::class);
        // $this->call(ProductStocksTableSeeder::class);
        $this->call(RefundRequestsTableSeeder::class);
        $this->call(OffersTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderItemsTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
        $this->call(SeosTableSeeder::class);
        $this->call(SiteSettingsTableSeeder::class);
        $this->call(ThemeSettingsTableSeeder::class);
        $this->call(TrackingScriptsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ActivityLogTableSeeder::class);
        // $this->call(LoginActivitiesTableSeeder::class);
    }
}
