<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reviews')->delete();
        
        \DB::table('reviews')->insert(array (
            0 => 
            array (
                'id' => 201,
                'product_id' => 47,
                'user_name' => 'Sophia R',
                'rating' => 5,
                'comment' => 'Absolutely love this fragrance! Floral and long-lasting. Top Trends UK delivered fast and free across the UK!
',
                'created_at' => '2025-05-20 04:16:46',
                'updated_at' => '2025-05-20 04:16:46',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 202,
                'product_id' => 36,
                'user_name' => 'Amelia H.',
                'rating' => 5,
                'comment' => 'Absolutely in love with this scent. It lasts all day and smells luxurious. Delivered in 2 days – brilliant service!',
                'created_at' => '2025-05-20 20:48:57',
                'updated_at' => '2025-05-20 20:58:27',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 203,
                'product_id' => 36,
                'user_name' => 'Rebecca W.',
                'rating' => 5,
                'comment' => 'Genuine product at a much better price than the high street. Will be buying again for sure.',
                'created_at' => '2025-05-20 20:49:28',
                'updated_at' => '2025-05-20 20:58:13',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 204,
                'product_id' => 37,
                'user_name' => 'Lucy J.',
                'rating' => 5,
                'comment' => 'Bought this for my husband. He gets compliments every time he wears it. Super fast delivery!',
                'created_at' => '2025-05-20 20:50:27',
                'updated_at' => '2025-05-20 20:56:31',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 205,
                'product_id' => 37,
                'user_name' => 'Chris B.',
                'rating' => 5,
                'comment' => 'Strong, masculine, and authentic. Better than expected. Quick UK delivery too.',
                'created_at' => '2025-05-20 20:51:04',
                'updated_at' => '2025-05-20 20:55:57',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 206,
                'product_id' => 38,
                'user_name' => 'Deborah L.',
                'rating' => 5,
                'comment' => 'A timeless classic. Smells elegant and the price here is unbeatable.',
                'created_at' => '2025-05-20 20:55:25',
                'updated_at' => '2025-05-20 20:55:25',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 207,
                'product_id' => 38,
                'user_name' => 'Emma P.',
                'rating' => 4,
                'comment' => 'My mum was thrilled. Genuine Chanel, beautifully packaged, and delivered in 48 hours.',
                'created_at' => '2025-05-20 20:59:06',
                'updated_at' => '2025-05-20 20:59:06',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 208,
                'product_id' => 39,
                'user_name' => 'Natalie C.',
                'rating' => 4,
                'comment' => 'This is my signature scent – powerful but feminine. Always a smooth experience ordering from here.',
                'created_at' => '2025-05-20 20:59:36',
                'updated_at' => '2025-05-20 20:59:36',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 209,
                'product_id' => 39,
                'user_name' => 'Fiona R.',
                'rating' => 5,
                'comment' => 'Love the intense version even more than the original. Worth every penny!',
                'created_at' => '2025-05-20 21:00:06',
                'updated_at' => '2025-05-20 21:00:06',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 210,
                'product_id' => 40,
                'user_name' => 'Sarah D.',
                'rating' => 4,
                'comment' => 'Smells divine! Sweet but sophisticated. Delivery to London was super fast.',
                'created_at' => '2025-05-20 21:01:31',
                'updated_at' => '2025-05-20 21:01:31',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 211,
                'product_id' => 40,
                'user_name' => 'Holly M.',
                'rating' => 4,
                'comment' => 'This is a head-turner! Very happy with the service and the price.',
                'created_at' => '2025-05-20 21:02:00',
                'updated_at' => '2025-05-20 21:02:00',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 212,
                'product_id' => 41,
                'user_name' => 'Isabelle F.',
                'rating' => 4,
                'comment' => 'Bought for my partner – he smells incredible and loves it. Arrived in perfect condition.',
                'created_at' => '2025-05-20 21:02:28',
                'updated_at' => '2025-05-20 21:02:28',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 213,
                'product_id' => 41,
                'user_name' => 'Mark E.',
                'rating' => 5,
                'comment' => 'Classy and long-lasting. Will be ordering again before this one runs out.',
                'created_at' => '2025-05-20 21:02:52',
                'updated_at' => '2025-05-20 21:02:52',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 214,
                'product_id' => 44,
                'user_name' => 'Jessica N.',
                'rating' => 5,
                'comment' => 'Such a confident, bold scent. Compliments every time I wear it.',
                'created_at' => '2025-05-20 21:03:43',
                'updated_at' => '2025-05-20 21:03:43',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 215,
                'product_id' => 42,
                'user_name' => 'Anna S.',
                'rating' => 5,
                'comment' => 'Great value and next-day delivery. Can’t fault it.',
                'created_at' => '2025-05-20 21:04:05',
                'updated_at' => '2025-05-20 21:04:05',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 216,
                'product_id' => 43,
                'user_name' => 'Darren T.',
                'rating' => 5,
                'comment' => 'Smells rich and powerful – definitely the real thing. Arrived in just 2 days',
                'created_at' => '2025-05-20 21:04:38',
                'updated_at' => '2025-05-20 21:04:38',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 217,
                'product_id' => 44,
                'user_name' => 'Rachel G.',
                'rating' => 5,
                'comment' => 'Floral and sexy – I wear this almost every day. Great experience with the store.',
                'created_at' => '2025-05-20 21:05:07',
                'updated_at' => '2025-05-20 21:05:07',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 218,
                'product_id' => 45,
                'user_name' => 'Samantha T.',
                'rating' => 5,
                'comment' => 'This scent is so fresh and feminine. Highly recommend!',
                'created_at' => '2025-05-20 21:05:55',
                'updated_at' => '2025-05-20 21:05:55',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 219,
                'product_id' => 47,
                'user_name' => 'Harriet M.',
                'rating' => 5,
                'comment' => 'Gardenia is my favourite flower and this perfume does it justice. Very pleased.',
                'created_at' => '2025-05-20 21:06:20',
                'updated_at' => '2025-05-20 21:06:20',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 220,
                'product_id' => 42,
                'user_name' => 'Saim',
                'rating' => 5,
                'comment' => 'Highly recommended totally prompt perfumes',
                'created_at' => '2025-05-21 19:24:52',
                'updated_at' => '2025-05-21 19:24:52',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 221,
                'product_id' => 43,
                'user_name' => 'Jawad',
                'rating' => 5,
                'comment' => 'Value to money item just used it & long lasting cheers',
                'created_at' => '2025-05-21 19:26:25',
                'updated_at' => '2025-05-21 19:26:25',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 222,
                'product_id' => 46,
                'user_name' => 'Zahid',
                'rating' => 5,
                'comment' => 'Just bought it for my friend & he really loved it totally authentic fragrances',
                'created_at' => '2025-05-21 19:28:08',
                'updated_at' => '2025-05-21 19:28:08',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}