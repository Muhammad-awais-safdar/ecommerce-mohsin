<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products')->delete();
        
        \DB::table('products')->insert(array (
            0 => 
            array (
                'id' => 36,
                'name' => 'Dior Sauvage Elixir - 60ml',
                'slug' => 'dior-sauvage-elixir-60ml',
                // 'description' => 'Unleash your wild side with Dior Sauvage Elixir, a bold and intense men\'s fragrance. Featuring rich notes of cinnamon, nutmeg, cardamom, and lavender, this luxury scent is perfect for evening wear and special occasions. Its long-lasting formula and powerful sillage make it a standout in any fragrance collection.',
                // 'sku' => NULL,
                'discount_percentage' => 35,
                'price' => '109.00',
                'status' => NULL,
                'images' => '["products\\/01JV9TN0YQ7Y1R7596Y6Y21CBN.jpg","products\\/01JV9TN0YWR26WMBF31BYSACP5.jpg","products\\/01JV9TN0YXHKB19R05GSMQ2ASK.jpg"]',
                'created_at' => '2025-05-14 19:55:26',
                'updated_at' => '2025-07-06 22:40:12',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 37,
                'name' => 'Dior Sauvage Eau de Parfum - 60ml',
                'slug' => 'dior-sauvage-eau-de-parfum-60ml',
                // 'description' => 'Embrace rugged elegance with Dior Sauvage EDP, a refined yet bold fragrance for men. With top notes of Calabrian bergamot and heart notes of Sichuan pepper and lavender, this fragrance offers a fresh yet warm scent that lasts all day. Ideal for daily wear or evening outings.',
                // 'sku' => NULL,
                'discount_percentage' => 33,
                'price' => '99.00',
                'status' => NULL,
                'images' => '["products\\/01JVAHBWG8ACDDTYZ9Y7JPWK6E.jpg","products\\/01JVAHBWGAVFYGRK57B2A5TXFY.jpg","products\\/01JVAHBWGBGC46SCDN3RZN1499.jpg"]',
                'created_at' => '2025-05-14 19:56:48',
                'updated_at' => '2025-07-06 22:39:34',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 38,
                'name' => 'Chanel No. 5 Eau de Parfum - 60ml',
                'slug' => 'chanel-no-5-eau-de-parfum-60ml',
                // 'description' => 'A timeless classic, Coco Chanel No. 5 is the definition of elegance and femininity. This floral aldehyde perfume features notes of jasmine, rose, ylang-ylang, and vanilla. Perfect for sophisticated women who appreciate classic, iconic fragrances that never go out of style.',
                // 'sku' => NULL,
                'discount_percentage' => 30,
                'price' => '99.00',
                'status' => NULL,
                'images' => '["products\\/01JVAHJQZ4M0NAA7AGRW81QYXT.jpg","products\\/01JVAHJQZ62DG9AHDXN4KZKPGV.jpg","products\\/01JVAHJQZ7SRVYTXN4MHN009PT.jpg"]',
                'created_at' => '2025-05-14 19:57:23',
                'updated_at' => '2025-05-22 03:41:23',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 39,
                'name' => 'Coco Chanel Mademoiselle Intense - 100ml',
                'slug' => 'coco-chanel-mademoiselle-intense-100ml',
                // 'description' => 'Indulge in the sensual warmth of Coco Mademoiselle Intense, a deep and captivating scent for confident women. With a powerful blend of patchouli, tonka bean, and rose, this fragrance offers a bold twist on the classic Mademoiselle. Best for evening wear and lasting impressions.',
                // 'sku' => NULL,
                'discount_percentage' => 30,
                'price' => '99.00',
                'status' => NULL,
                'images' => '["products\\/01JVAHPSCEBHXND8C0D0BM05KF.jpg","products\\/01JVAHPSCFGG42MZDMGW21QXC1.jpg","products\\/01JVAHPSCG4K15P0JP2SEQDW3E.jpg"]',
                'created_at' => '2025-05-14 19:58:08',
                'updated_at' => '2025-05-22 03:41:17',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 40,
                'name' => 'Tom Ford Lost Cherry - 50ml',
                'slug' => 'tom-ford-lost-cherry-50ml',
                // 'description' => 'Sweet, seductive, and luxurious, Tom Ford Lost Cherry is a unisex fragrance that blends sweet cherry, bitter almond, and warm tonka bean. A perfect mix of innocence and indulgence, it’s a top choice for those who want a unique and sensual scent.',
                // 'sku' => NULL,
                'discount_percentage' => 30,
                'price' => '99.00',
                'status' => NULL,
                'images' => '["products\\/01JV7MWQG5ZQT4JTRFTTKX5G8F.jpg","products\\/01JV7MWQG6422NBYK6S8K7JGCF.jpg","products\\/01JV7MWQGCMEM221VKYW0VXDRM.jpg"]',
                'created_at' => '2025-05-14 19:59:01',
                'updated_at' => '2025-05-22 03:41:08',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 41,
                'name' => 'Bleu De Chanel Eau de Parfum - 100ml ',
                'slug' => 'bleu-de-chanel-eau-de-parfum-100ml',
                // 'description' => 'Bleu De Chanel EDP is a sophisticated and woody aromatic fragrance for men. With citrusy top notes, followed by ginger, sandalwood, and incense, it delivers a clean yet masculine scent. Ideal for professional and casual settings.',
                // 'sku' => NULL,
                'discount_percentage' => 32,
                'price' => '109.00',
                'status' => NULL,
                'images' => '["products\\/01JVAJ1JJ1HXC6HF9FHN03R65F.jpg","products\\/01JVAJ1JJ23B5EGG52WG8KDG1H.jpg","products\\/01JVAJ1JJ38PNT4B76SA57PQ6R.jpg"]',
                'created_at' => '2025-05-14 19:59:46',
                'updated_at' => '2025-07-06 22:38:39',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 42,
                'name' => 'YSL Libre Eau de Parfum - 90ml',
                'slug' => 'ysl-libre-eau-de-parfum-90ml',
                // 'description' => 'Bold and empowering, YSL Libre is a floral fragrance for the modern woman. Combining lavender essence with orange blossom and musk accord, it captures freedom and femininity in a bottle. Perfect for day or night wear.',
                // 'sku' => NULL,
                'discount_percentage' => 25,
                'price' => '100.00',
                'status' => NULL,
                'images' => '["products\\/01JVAJ3M34ES6T1N3D62EX5SY6.jpg","products\\/01JVAJ3M35844P9BP2YHAWTAC1.jpg","products\\/01JVAJ3M3689WETXCR29M245GC.jpg"]',
                'created_at' => '2025-05-14 20:00:18',
                'updated_at' => '2025-05-22 03:39:49',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 43,
                'name' => 'Creed Aventus - 100ml ',
                'slug' => 'creed-aventus-100ml',
                // 'description' => 'A scent of success and strength, Creed Aventus is a legendary men\'s fragrance featuring notes of pineapple, birch, musk, and oakmoss. Designed for leaders and trailblazers, it’s a statement scent that exudes confidence.',
                // 'sku' => NULL,
                'discount_percentage' => 25,
                'price' => '100.00',
                'status' => NULL,
                'images' => '["products\\/01JVAJ68R9X7SGEDE8QGD6EP88.jpg","products\\/01JVAJ68RA5JGJNJEXFPYCK0G8.jpg","products\\/01JVAJ68RB7SKDD3SNDXE7G1SX.jpg"]',
                'created_at' => '2025-05-14 20:00:56',
                'updated_at' => '2025-05-22 03:39:41',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 44,
                'name' => 'Valentino Born in Roma - 100ml',
                'slug' => 'valentino-born-in-roma-100ml',
                // 'description' => 'Valentino Born in Roma is a contemporary floral amber fragrance for women. With top notes of jasmine and blackcurrant, and warm bourbon vanilla as its base, this scent celebrates individuality, femininity, and elegance.',
                // 'sku' => NULL,
                'discount_percentage' => 30,
                'price' => '109.00',
                'status' => NULL,
                'images' => '["products\\/01JVAJ9CC17KZVE4XY4ETEH40Q.jpg","products\\/01JVAJ9CC37BRAJMRZYE1KKJF8.jpg","products\\/01JVAJ9CC4VPY64FAY53VVNMET.jpg"]',
                'created_at' => '2025-05-14 20:01:30',
                'updated_at' => '2025-05-22 03:38:56',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 45,
                'name' => 'GUCCI Flora Gorgeous Magnolia EDP - 100ml',
                'slug' => 'gucci-flora-gorgeous-magnolia-edp-100ml',
                // 'description' => 'Gucci Flora Gorgeous Magnolia EDP - Unlock Radiant Floral Power

// Unlock your inner strength with Gucci Flora Gorgeous Magnolia, a radiant floral fragrance for women. A captivating blend of Magnolia Essence, Dewberries Accord, and Patchouli Essence, this scent balances fresh and sensual notes for a memorable fragrance experience.

// The floral heart of Magnolia Essence offers a bright, feminine sweetness, while Dewberries Accord adds an irresistible fruity touch. Patchouli Essence grounds the fragrance with earthy woodiness, enhanced by the smooth, sensual Blond Woods. A Coconut Accord provides a sweet freshness, while Jasmine Sambac Absolute and Musks deliver a warm, enticing finish.

// Fragrance Type: Floral
// Key Notes: Magnolia Essence, Dewberries Accord, Patchouli Essence, Blond Woods, Coconut Accord, Jasmine Sambac, Musks
// Long-lasting & Compliment-worthy: A perfect balance of freshness and warmth for all-day wear.',
                // 'sku' => NULL,
                'discount_percentage' => 30,
                'price' => '99.00',
                'status' => NULL,
                'images' => '["products\\/01JVAJCWY3ET7NC028W128R5J6.jpg","products\\/01JVAJCWY5HX6CZT5H7ERM9S60.jpg","products\\/01JVAJCWY6SQSR0GFB1NSDRW5J.jpg"]',
                'created_at' => '2025-05-15 03:31:45',
                'updated_at' => '2025-05-22 03:37:44',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 46,
                'name' => 'GUCCI Flora Gorgeous Jasmine EDP - 100ml',
                'slug' => 'gucci-flora-gorgeous-jasmine-edp-100ml',
//                 'description' => 'Gucci Flora Gorgeous Jasmine Eau de Parfum – 100ML
// Step into a world of elegance and sensuality with Gucci Flora Gorgeous Jasmine, a radiant Eau de Parfum that captures the essence of natural beauty. Centered around Grandiflorum Jasmine, this luxurious fragrance unfolds with a bouquet of white jasmine petals, enhanced by mandarin essence and bergamot for a fresh, luminous opening.

// As it settles, warm sandalwood and benzoin create a creamy, comforting base that lingers on the skin with grace. The soft, floral trail makes this scent perfect for both day and evening wear — a true signature fragrance for the modern, confident woman.

// Fragrance Notes:
// Top Notes: Mandarin Essence, Bergamot

// Heart Notes: Grandiflorum Jasmine, Magnolia

// Base Notes: Sandalwood, Benzoin

// 💐 Elegant, joyful, and radiant — Gucci Flora Gorgeous Jasmine is a timeless expression of femininity.',
                // 'sku' => NULL,
                'discount_percentage' => 30,
                'price' => '99.00',
                'status' => NULL,
                'images' => '["products\\/01JVAJEXG0XCP4EZ1JWQZNK9RV.jpg","products\\/01JVAJEXG299XE994CG4SY291E.jpg","products\\/01JVAJEXG41BMAH3MPFJJANF4F.jpg"]',
                'created_at' => '2025-05-15 03:36:00',
                'updated_at' => '2025-05-22 03:37:33',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 47,
                'name' => 'GUCCI Flora Gorgeous Gardenia EDP - 100ml',
                'slug' => 'gucci-flora-gorgeous-gardenia-edp-100ml',
//                 'description' => 'GUCCI Flora Gorgeous Gardenia Eau de Parfum – 100ML
// Experience the charm of blooming elegance with Gucci Flora Gorgeous Gardenia, a joyful and enchanting Eau de Parfum inspired by the delicate yet powerful nature of the gardenia flower.

// This captivating fragrance opens with a fresh burst of pear blossom and red berries, leading into a heart of white gardenia and frangipani flower. The scent gently settles into a warm, comforting base of brown sugar and patchouli, creating a beautifully balanced floral-gourmand perfume.

// Wrapped in a stunning pink bottle adorned with the iconic Flora pattern, it’s a perfect scent for those who embrace beauty, happiness, and self-expression.

// Fragrance Notes:
// Top Notes: Pear Blossom, Red Berries

// Heart Notes: White Gardenia, Frangipani

// Base Notes: Brown Sugar, Patchouli

// 🌸 Feminine, radiant, and playful — Gucci Flora Gorgeous Gardenia is your go-to signature for everyday luxury.',
                // 'sku' => NULL,
                'discount_percentage' => 35,
                'price' => '99.00',
                'status' => NULL,
                'images' => '["products\\/01JVAJH8KN0GRR85QRPWB4P7JJ.jpg","products\\/01JVAJH8KQFZRT80DDQWPJHYB1.jpg","products\\/01JVAJH8KRGR1Q7065BVXSAX2Y.jpg"]',
                'created_at' => '2025-05-15 03:39:03',
                'updated_at' => '2025-07-06 21:48:23',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}