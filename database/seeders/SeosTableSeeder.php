<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('seos')->delete();
        
        \DB::table('seos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'page' => 'home',
                'meta_title' => 'Buy Luxury Perfumes | Top Trends UK',
                'meta_description' => 'Shop Luxury Perfumes at Top Trends UK. Explore authentic designer scents from Chanel, Dior, Tom Ford & more. Elegance, quality & fast UK delivery guaranteed.',
                'meta_keywords' => 'online store, buy online, ecommerce, yourshop',
                'og_title' => 'Buy Luxury Perfumes | Top Trends UK',
                'og_image' => 'seo/og/01JV9VGCN2CJ11JSBZCTJZSJHD.png',
                'canonical_url' => 'https://toptrendsuk.store',
                'robots' => 'index, follow',
                'twitter_title' => 'Buy Luxury Perfumes | Top Trends UK',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-15 16:39:02',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'page' => 'shop',
                'meta_title' => 'Browse All Products | Shop Now at YourShop',
                'meta_description' => 'Explore all categories and discover top products at affordable prices. Safe checkout and fast delivery guaranteed.',
                'meta_keywords' => 'shop online, categories, buy now, ecommerce deals',
                'og_title' => 'Browse All Products - Luxury Perfumes | Top Trends UK',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/shop',
                'robots' => 'index, follow',
                'twitter_title' => 'Browse All Products | Shop Now at YourShop',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-15 03:40:12',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'page' => 'product.show',
                'meta_title' => 'Product Details & Reviews | YourShop',
                'meta_description' => 'Get detailed information, specifications, and reviews on our best-selling products. Limited stock available!',
                'meta_keywords' => 'product review, item details, features, buy product',
                'og_title' => 'Product Details & Reviews | YourShop',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/product/{id}',
                'robots' => 'index, follow',
                'twitter_title' => 'Product Details & Reviews | YourShop',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'page' => 'about',
                'meta_title' => 'About Us | Learn About YourShop’s Story',
                'meta_description' => 'We are passionate about delivering quality products at great prices. Learn more about our mission and values.',
                'meta_keywords' => 'about yourshop, company info, ecommerce story',
                'og_title' => 'About Us | Learn About YourShop’s Story',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/about',
                'robots' => 'index, follow',
                'twitter_title' => 'About Us | Learn About YourShop’s Story',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'page' => 'contact',
                'meta_title' => 'Contact Us | Get in Touch With YourShop',
                'meta_description' => 'Need help? Reach out to our support team for product inquiries, shipping info, or feedback.',
                'meta_keywords' => 'contact yourshop, support, help, get in touch',
                'og_title' => 'Contact Us | Get in Touch With YourShop',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/contact',
                'robots' => 'index, follow',
                'twitter_title' => 'Contact Us | Get in Touch With YourShop',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'page' => 'cart',
                'meta_title' => 'Your Shopping Cart | Review & Checkout',
                'meta_description' => 'Review your selected items and proceed to a secure checkout. Make changes to your cart anytime.',
                'meta_keywords' => 'shopping cart, checkout, order items, ecommerce cart',
                'og_title' => 'Your Shopping Cart | Review & Checkout',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/cart',
                'robots' => 'index, follow',
                'twitter_title' => 'Your Shopping Cart | Review & Checkout',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'page' => 'checkout',
                'meta_title' => 'Secure Checkout | YourShop',
                'meta_description' => 'Fast and secure checkout experience. Enter your shipping and payment details with confidence.',
                'meta_keywords' => 'checkout, payment, order summary, secure payment',
                'og_title' => 'Secure Checkout | YourShop',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/checkout',
                'robots' => 'index, follow',
                'twitter_title' => 'Secure Checkout | YourShop',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'page' => 'checkout.payment',
                'meta_title' => 'Payment Gateway | YourShop Secure Pay',
                'meta_description' => 'Complete your purchase through our secure payment portal. Trusted by thousands of happy customers.',
                'meta_keywords' => 'secure payment, pay online, checkout, ecommerce gateway',
                'og_title' => 'Payment Gateway | YourShop Secure Pay',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/checkout/payment',
                'robots' => 'index, follow',
                'twitter_title' => 'Payment Gateway | YourShop Secure Pay',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'page' => 'payment.success',
                'meta_title' => 'Order Confirmed | Thank You for Shopping',
                'meta_description' => 'Your order has been successfully placed. We’ll notify you when it’s shipped. Track your order anytime.',
                'meta_keywords' => 'order success, purchase confirmed, thank you, order done',
                'og_title' => 'Order Confirmed | Thank You for Shopping',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/payment/success',
                'robots' => 'index, follow',
                'twitter_title' => 'Order Confirmed | Thank You for Shopping',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'page' => 'payment.failure',
                'meta_title' => 'Payment Failed | Please Try Again',
                'meta_description' => 'There was an issue processing your payment. Please review your details or use a different method.',
                'meta_keywords' => 'payment failed, error, retry payment, checkout issue',
                'og_title' => 'Payment Failed | Please Try Again',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/payment/failure',
                'robots' => 'index, follow',
                'twitter_title' => 'Payment Failed | Please Try Again',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'page' => 'refund.request.form',
                'meta_title' => 'Request a Refund | YourShop Help Center',
                'meta_description' => 'Need a refund? Fill out the refund request form and we’ll process it as soon as possible.',
                'meta_keywords' => 'refund request, return item, money back, request refund',
                'og_title' => 'Request a Refund | YourShop Help Center',
                'og_image' => NULL,
                'canonical_url' => 'https://toptrendsuk.store/refund-request',
                'robots' => 'index, follow',
                'twitter_title' => 'Request a Refund | YourShop Help Center',
                'twitter_image' => NULL,
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}