<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_items')->delete();
        
        \DB::table('order_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'order_id' => 51,
                'product_id' => 46,
                'quantity' => 1,
                'price' => '47.60',
                'created_at' => '2025-05-15 18:49:17',
                'updated_at' => '2025-05-15 18:49:17',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'order_id' => 51,
                'product_id' => 42,
                'quantity' => 1,
                'price' => '47.60',
                'created_at' => '2025-05-15 18:49:17',
                'updated_at' => '2025-05-15 18:49:17',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'order_id' => 51,
                'product_id' => 43,
                'quantity' => 1,
                'price' => '47.60',
                'created_at' => '2025-05-15 18:49:17',
                'updated_at' => '2025-05-15 18:49:17',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'order_id' => 51,
                'product_id' => 41,
                'quantity' => 1,
                'price' => '47.60',
                'created_at' => '2025-05-15 18:49:17',
                'updated_at' => '2025-05-15 18:49:17',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'order_id' => 52,
                'product_id' => 46,
                'quantity' => 1,
                'price' => '47.60',
                'created_at' => '2025-05-15 19:05:31',
                'updated_at' => '2025-05-15 19:05:31',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'order_id' => 52,
                'product_id' => 47,
                'quantity' => 1,
                'price' => '47.60',
                'created_at' => '2025-05-15 19:05:31',
                'updated_at' => '2025-05-15 19:05:31',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'order_id' => 53,
                'product_id' => 38,
                'quantity' => 1,
                'price' => '69.30',
                'created_at' => '2025-05-27 22:15:06',
                'updated_at' => '2025-05-27 22:15:06',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'order_id' => 53,
                'product_id' => 40,
                'quantity' => 1,
                'price' => '69.30',
                'created_at' => '2025-05-27 22:15:06',
                'updated_at' => '2025-05-27 22:15:06',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'order_id' => 54,
                'product_id' => 39,
                'quantity' => 1,
                'price' => '69.30',
                'created_at' => '2025-05-31 14:42:30',
                'updated_at' => '2025-05-31 14:42:30',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'order_id' => 55,
                'product_id' => 39,
                'quantity' => 1,
                'price' => '69.30',
                'created_at' => '2025-06-06 16:09:21',
                'updated_at' => '2025-06-06 16:09:21',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'order_id' => 56,
                'product_id' => 41,
                'quantity' => 1,
                'price' => '81.75',
                'created_at' => '2025-06-06 16:22:08',
                'updated_at' => '2025-06-06 16:22:08',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'order_id' => 57,
                'product_id' => 41,
                'quantity' => 1,
                'price' => '81.75',
                'created_at' => '2025-06-06 17:09:34',
                'updated_at' => '2025-06-06 17:09:34',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'order_id' => 58,
                'product_id' => 39,
                'quantity' => 1,
                'price' => '69.30',
                'created_at' => '2025-07-06 17:39:37',
                'updated_at' => '2025-07-06 17:39:37',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'order_id' => 59,
                'product_id' => 41,
                'quantity' => 1,
                'price' => '81.75',
                'created_at' => '2025-07-06 18:28:29',
                'updated_at' => '2025-07-06 18:28:29',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'order_id' => 60,
                'product_id' => 41,
                'quantity' => 1,
                'price' => '74.12',
                'created_at' => '2025-07-12 16:59:55',
                'updated_at' => '2025-07-12 16:59:55',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}