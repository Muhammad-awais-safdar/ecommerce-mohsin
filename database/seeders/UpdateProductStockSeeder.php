<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all products to have stock if they don't already have it
        $products = \App\Models\Product::all();
        
        foreach ($products as $product) {
            // Check if product already has stock record
            if (!$product->stock) {
                \App\Models\ProductStock::create([
                    'product_id' => $product->id,
                    'quantity' => rand(10, 100) // Random stock between 10-100
                ]);
            }
            
            // Set some initial sales data
            $product->update([
                'total_sales' => rand(5, 50),
                'last_sale_at' => now()->subHours(rand(1, 48))
            ]);
        }
    }
}
