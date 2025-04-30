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
            'discount_percentage'=>'40',
            'price' => 50.00,
            
        ]);

        Product::create([
            'name' => 'Perfume B',
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume B',
            'discount_percentage'=>'40',
            'price' => 60.00,
            
        ]);

        Product::create([
            'name' => 'Perfume C',
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume C',
            'discount_percentage'=>'40',
            'price' => 75.00,
            
        ]);

        Product::create([
            'name' => 'Perfume D',
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume D',
            'discount_percentage'=>'40',
            'price' => 85.00,
            
        ]);

        Product::create([
            'name' => 'Perfume E',
            'image' => 'https://placehold.co/600x400',
            'description' => 'Description of Perfume E',
            'discount_percentage'=>'40',
            'price' => 45.00,
            
        ]);
    }
}