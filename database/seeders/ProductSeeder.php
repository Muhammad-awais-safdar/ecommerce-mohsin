<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Seed 10 demo products
        Product::create([
            'name' => 'Perfume A',
            'description' => 'Description of Perfume A',
            'price' => 50.00,
            
        ]);

        Product::create([
            'name' => 'Perfume B',
            'description' => 'Description of Perfume B',
            'price' => 60.00,
            
        ]);

        Product::create([
            'name' => 'Perfume C',
            'description' => 'Description of Perfume C',
            'price' => 75.00,
            
        ]);

        Product::create([
            'name' => 'Perfume D',
            'description' => 'Description of Perfume D',
            'price' => 85.00,
            
        ]);

        Product::create([
            'name' => 'Perfume E',
            'description' => 'Description of Perfume E',
            'price' => 45.00,
            
        ]);
    }
}