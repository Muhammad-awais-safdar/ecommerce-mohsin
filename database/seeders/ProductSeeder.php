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
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume A',
            'price' => 50.00,
            
        ]);

        Product::create([
            'name' => 'Perfume B',
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume B',
            'price' => 60.00,
            
        ]);

        Product::create([
            'name' => 'Perfume C',
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume C',
            'price' => 75.00,
            
        ]);

        Product::create([
            'name' => 'Perfume D',
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume D',
            'price' => 85.00,
            
        ]);

        Product::create([
            'name' => 'Perfume E',
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume E',
            'price' => 45.00,
            
        ]);
    }
}