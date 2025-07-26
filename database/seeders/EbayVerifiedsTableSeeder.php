<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EbayVerifiedsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ebay_verifieds')->delete();
        
        \DB::table('ebay_verifieds')->insert(array (
            0 => 
            array (
                'id' => 1,
                'imagePath' => 'ebay_verifieds/1.png',
                'imageName' => '1',
                'created_at' => '2025-05-14 04:52:04',
                'updated_at' => '2025-05-19 18:43:14',
                'deleted_at' => '2025-05-19 18:43:14',
            ),
            1 => 
            array (
                'id' => 2,
                'imagePath' => 'ebay_verifieds/2.png',
                'imageName' => '2',
                'created_at' => '2025-05-14 07:52:48',
                'updated_at' => '2025-05-19 18:43:14',
                'deleted_at' => '2025-05-19 18:43:14',
            ),
            2 => 
            array (
                'id' => 3,
                'imagePath' => 'ebay_verifieds/3.png',
                'imageName' => '3',
                'created_at' => '2025-05-14 15:07:05',
                'updated_at' => '2025-05-19 18:43:14',
                'deleted_at' => '2025-05-19 18:43:14',
            ),
            3 => 
            array (
                'id' => 4,
                'imagePath' => 'ebay_verifieds/4.png',
                'imageName' => '4',
                'created_at' => '2025-05-14 15:07:20',
                'updated_at' => '2025-05-19 18:43:14',
                'deleted_at' => '2025-05-19 18:43:14',
            ),
            4 => 
            array (
                'id' => 5,
                'imagePath' => 'ebay_verifieds/5.png',
                'imageName' => '5',
                'created_at' => '2025-05-14 15:07:37',
                'updated_at' => '2025-05-19 18:43:14',
                'deleted_at' => '2025-05-19 18:43:14',
            ),
            5 => 
            array (
                'id' => 6,
                'imagePath' => 'ebay_verifieds/6.png',
                'imageName' => '6',
                'created_at' => '2025-05-14 15:07:52',
                'updated_at' => '2025-05-19 18:43:14',
                'deleted_at' => '2025-05-19 18:43:14',
            ),
            6 => 
            array (
                'id' => 7,
                'imagePath' => 'ebay_verifieds/1.jpg',
                'imageName' => '1',
                'created_at' => '2025-05-19 18:43:35',
                'updated_at' => '2025-05-19 18:43:35',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'imagePath' => 'ebay_verifieds/2.jpg',
                'imageName' => '2',
                'created_at' => '2025-05-19 18:43:48',
                'updated_at' => '2025-05-19 18:43:48',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'imagePath' => 'ebay_verifieds/3.jpg',
                'imageName' => '3',
                'created_at' => '2025-05-19 18:43:59',
                'updated_at' => '2025-05-19 18:43:59',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'imagePath' => 'ebay_verifieds/4.jpg',
                'imageName' => '4',
                'created_at' => '2025-05-19 18:44:10',
                'updated_at' => '2025-05-19 18:44:10',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'imagePath' => 'ebay_verifieds/5.jpg',
                'imageName' => '5',
                'created_at' => '2025-05-19 18:44:22',
                'updated_at' => '2025-05-19 18:44:22',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'imagePath' => 'ebay_verifieds/6.jpg',
                'imageName' => '6',
                'created_at' => '2025-05-19 18:44:35',
                'updated_at' => '2025-05-19 18:44:35',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}