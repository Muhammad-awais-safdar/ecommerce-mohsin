<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orders')->delete();
        
        \DB::table('orders')->insert(array (
            0 => 
            array (
                'id' => 51,
                'customer_name' => 'Saim Awais',
                'customer_email' => 'isaimawais@gmail.com',
                'customer_phone' => '07404360383',
                'shipping_address' => 'N17 9QU Unit 3 excel foods, Haringey, London, United Kingdom - N17 9QU',
                'total_amount' => '190.40',
                'status' => 'paid',
                'tracking_number' => 'MZ332171645GB',
                'tracking_service_provider' => 'Royal Mail',
                'tracking_status' => 'processing',
                'created_at' => '2025-05-15 18:49:17',
                'updated_at' => '2025-05-17 15:48:04',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 52,
                'customer_name' => 'Saim Awais',
                'customer_email' => 'isaimawais@gmail.com',
                'customer_phone' => '07404360383',
                'shipping_address' => 'N17 9QU, London, United kingdom, United Kingdom - N17 9QU, Unit 3 excel foods',
                'total_amount' => '95.20',
                'status' => 'paid',
                'tracking_number' => 'MZ332171645GB',
                'tracking_service_provider' => 'Royal Mail',
                'tracking_status' => 'processing',
                'created_at' => '2025-05-15 19:05:31',
                'updated_at' => '2025-05-17 15:47:47',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 53,
                'customer_name' => 'test test',
                'customer_email' => 'abdulrehmannadeem@gmail.com',
                'customer_phone' => '03348480444',
                'shipping_address' => '123 address, london, london city, United Kingdom - E1 0AA',
                'total_amount' => '138.60',
                'status' => 'pending',
                'tracking_number' => 'FOHWGGTOH2',
                'tracking_service_provider' => NULL,
                'tracking_status' => 'processing',
                'created_at' => '2025-05-27 22:15:06',
                'updated_at' => '2025-05-27 22:15:06',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 54,
                'customer_name' => 'Taiwo Olayiwola',
                'customer_email' => 'mariamolayiwola81@gmail.com',
                'customer_phone' => '07721674832',
                'shipping_address' => '53 basement flat Romsey Road Winchester, Winchester, United Kingdom, United Kingdom - SO22 5DE',
                'total_amount' => '69.30',
                'status' => 'pending',
                'tracking_number' => 'R94BW0MPWQ',
                'tracking_service_provider' => NULL,
                'tracking_status' => 'processing',
                'created_at' => '2025-05-31 14:42:30',
                'updated_at' => '2025-05-31 14:42:30',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 55,
                'customer_name' => 'muhammad abdulllah',
                'customer_email' => 'muhammad.abdullah0426@gmail.com',
                'customer_phone' => '+447577309416',
                'shipping_address' => 'Flat 1-8, George Drewry Court 85 London Road London, brimingham, united kingdom, United Kingdom - E13 0DA',
                'total_amount' => '69.30',
                'status' => 'paid',
                'tracking_number' => 'TOETCVNAM0',
                'tracking_service_provider' => NULL,
                'tracking_status' => 'processing',
                'created_at' => '2025-06-06 16:09:21',
                'updated_at' => '2025-06-06 16:12:54',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 56,
                'customer_name' => 'muhammad abdulllah',
                'customer_email' => 'muhammad.abdullah0426@gmail.com',
                'customer_phone' => '+447577309416',
                'shipping_address' => 'Flat 1-8, George Drewry Court 85 London Road London, brimingham, united kingdom, United Kingdom - E13 0DA',
                'total_amount' => '81.75',
                'status' => 'paid',
                'tracking_number' => 'LN3HFL7ZRT',
                'tracking_service_provider' => NULL,
                'tracking_status' => 'processing',
                'created_at' => '2025-06-06 16:22:08',
                'updated_at' => '2025-06-06 16:23:17',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 57,
                'customer_name' => 'muhammad abdulllah',
                'customer_email' => 'muhammad.abdullah0426@gmail.com',
                'customer_phone' => '07577309416',
                'shipping_address' => 'Flat 1-8, George Drewry Court 85 London Road London, brimingham, united kingdom, United Kingdom - E13 0DA',
                'total_amount' => '81.75',
                'status' => 'paid',
                'tracking_number' => 'MELO1GK2RB',
                'tracking_service_provider' => NULL,
                'tracking_status' => 'processing',
                'created_at' => '2025-06-06 17:09:34',
                'updated_at' => '2025-06-06 17:10:31',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 58,
                'customer_name' => 'Queenie Rushton',
                'customer_email' => 'rushton.mq@outlook.com',
                'customer_phone' => '07304 069588',
                'shipping_address' => 'DOWNSTAIRS ONLY 483B BARKING ROAD, London, Newham, United Kingdom - E138PS, PLAISTOW',
                'total_amount' => '69.30',
                'status' => 'paid',
                'tracking_number' => 'AW5HJGYRUU',
                'tracking_service_provider' => NULL,
                'tracking_status' => 'processing',
                'created_at' => '2025-07-06 17:39:37',
                'updated_at' => '2025-07-06 17:41:22',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 59,
                'customer_name' => 'Steve Barton',
                'customer_email' => 'bartonsteve088@gmail.com',
                'customer_phone' => '07368 680666',
                'shipping_address' => '198 Belswains Lane, Hemel Hempstead, England, United Kingdom - HP3 9XA',
                'total_amount' => '81.75',
                'status' => 'pending',
                'tracking_number' => 'LSUFUC53SL',
                'tracking_service_provider' => NULL,
                'tracking_status' => 'processing',
                'created_at' => '2025-07-06 18:28:29',
                'updated_at' => '2025-07-06 18:28:29',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 60,
                'customer_name' => 'Pravesh Singh',
                'customer_email' => 'knightknight672@gmail.com',
                'customer_phone' => '+447472925729',
                'shipping_address' => '156 Bath Road, Bristol, United Kingdom, United Kingdom - BS4 3EF',
                'total_amount' => '74.12',
                'status' => 'pending',
                'tracking_number' => 'S6AZXCU91W',
                'tracking_service_provider' => NULL,
                'tracking_status' => 'processing',
                'created_at' => '2025-07-12 16:59:55',
                'updated_at' => '2025-07-12 16:59:55',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}