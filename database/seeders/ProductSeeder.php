<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            'Perfume A',
            'Perfume B',
            'Perfume C',
            'Perfume D',
            'Perfume E',
        ];

        foreach ($products as $productName) {
            Product::create([
                'name' => $productName,
                'images' => [
                    'https://placehold.co/600x400?text=' . urlencode($productName . ' Image 1'),
                    'https://placehold.co/600x400?text=' . urlencode($productName . ' Image 2'),
                    'https://placehold.co/600x400?text=' . urlencode($productName . ' Image 3'),
                    'https://placehold.co/600x400?text=' . urlencode($productName . ' Image 4'),
                    'https://placehold.co/600x400?text=' . urlencode($productName . ' Image 5'),
                ],
                'description' => 'Description of ' . $productName,
                'discount_percentage' => '40',
                'price' => fake()->randomFloat(2, 40, 90),
            ]);
        }
    }
}
    