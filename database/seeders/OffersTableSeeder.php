<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('offers')->delete();
        
        \DB::table('offers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'product_id' => 39,
                'name' => 'awais',
                'email' => 'awaissafdar111@gmail.com',
                'phone' => '03067968983',
                'quantity' => '100',
                'offer_price' => '100.00',
                'status' => 'pending',
                'created_at' => '2025-05-15 08:00:26',
                'updated_at' => '2025-05-15 08:00:26',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'product_id' => 39,
                'name' => 'Quintessa Salazar',
                'email' => 'dudenohox@mailinator.com',
            'phone' => '+1 (352) 357-5487',
                'quantity' => '913',
                'offer_price' => '666.00',
                'status' => 'pending',
                'created_at' => '2025-05-15 08:00:35',
                'updated_at' => '2025-05-15 08:00:35',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'product_id' => 43,
                'name' => 'Samson Akinleye Akinleye',
                'email' => 'rotela2001@yahoo.com',
                'phone' => '07932991830',
                'quantity' => '1',
                'offer_price' => '50.00',
                'status' => 'pending',
                'created_at' => '2025-05-29 12:33:09',
                'updated_at' => '2025-05-29 12:33:09',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'product_id' => 43,
                'name' => 'Samson Akinleye Akinleye',
                'email' => 'rotela2001@yahoo.com',
                'phone' => '07932991830',
                'quantity' => '1',
                'offer_price' => '50.00',
                'status' => 'pending',
                'created_at' => '2025-05-29 12:33:10',
                'updated_at' => '2025-05-29 12:33:10',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'product_id' => 36,
                'name' => 'qnfkpjijhg',
                'email' => 'wwrjrvpj@testform.xyz',
                'phone' => '+1-643-110-7304',
                'quantity' => '1',
                'offer_price' => '8283.00',
                'status' => 'pending',
                'created_at' => '2025-06-21 01:42:58',
                'updated_at' => '2025-06-21 01:42:58',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}