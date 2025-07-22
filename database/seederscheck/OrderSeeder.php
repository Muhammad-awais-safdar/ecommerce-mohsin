<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Seed 5 demo orders
        Order::create([
            'customer_name' => 'John Doe',
            'customer_phone' => '1234567890',
            'customer_email' => 'awais@gmail.com',
            'shipping_address' => '123 Main St, Springfield',
            'total_amount' => 150.00,
            'status' => 'Paid',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Order::create([
            'customer_name' => 'Jane Smith',
            'customer_phone' => '9876543210',
            'customer_email' => 'awais@gmail.com',
            'shipping_address' => '456 Oak St, Springfield',
            'total_amount' => 200.00,
            'status' => 'Pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}