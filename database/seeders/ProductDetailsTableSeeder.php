<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductStock;
use Illuminate\Database\Seeder;

class ProductDetailsTableSeeder extends Seeder
{

    public function run(): void
    {
        $shortDescription = "Gucci Flora Gorgeous Jasmine is a radiant Eau de Parfum, capturing elegance and sensuality with Grandiflorum Jasmine and warm sandalwood.";

        $longDescription = "Gucci Flora Gorgeous Jasmine Eau de Parfum – 100ML Step into a world of elegance and sensuality with Gucci Flora Gorgeous Jasmine, a radiant Eau de Parfum that captures the essence of natural beauty. Centered around Grandiflorum Jasmine, this luxurious fragrance unfolds with a bouquet of white jasmine petals, enhanced by mandarin essence and bergamot for a fresh, luminous opening. As it settles, warm sandalwood and benzoin create a creamy, comforting base that lingers on the skin with grace. The soft, floral trail makes this scent perfect for both day and evening wear — a true signature fragrance for the modern, confident woman. Fragrance Notes: Top Notes: Mandarin Essence, Bergamot Heart Notes: Grandiflorum Jasmine, Magnolia Base Notes: Sandalwood, Benzoin 💐 Elegant, joyful, and radiant — Gucci Flora Gorgeous Jasmine is a timeless expression of femininity.";

        $products = Product::all();

        foreach ($products as $product) {
            // Create ProductDetail if doesn't exist
            if (!$product->details) {
                ProductDetail::insert([
                    'product_id'        => $product->id,
                    'short_description' => $shortDescription,
                    'long_description'  => $longDescription,
                    'gender'            => 'female',
                    'fragrance_type'    => 'floral',
                    'concentration'     => 'EDP',
                    'top_notes'         => 'Mandarin Essence, Bergamot',
                    'middle_notes'      => 'Grandiflorum Jasmine, Magnolia',
                    'base_notes'        => 'Sandalwood, Benzoin',
                    'volume_ml'         => 100,
                    'longevity_hours'   => 8,
                    'country_of_origin' => 'Italy',
                ]);
            }

            // Create ProductStock if doesn't exist
            if (!$product->stock) {
                ProductStock::create([
                    'product_id' => $product->id,
                    'quantity'   => rand(10, 50),
                ]);
            }
        }

        $this->command->info('Product details and stock seeded successfully!');
    }
}