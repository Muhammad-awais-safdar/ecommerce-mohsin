<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        // Attach products to orders
        $order1 = Order::find(1);
        $order2 = Order::find(2);

        $order1->orderItems()->create([
            'product_id' => Product::find(1)->id,
            'quantity' => 2,
            'price' => 50.00
        ]);

        $order1->orderItems()->create([
            'product_id' => Product::find(2)->id,
            'quantity' => 1,
            'price' => 60.00
        ]);

        $order2->orderItems()->create([
            'product_id' => Product::find(3)->id,
            'quantity' => 1,
            'price' => 75.00
        ]);
    }
}