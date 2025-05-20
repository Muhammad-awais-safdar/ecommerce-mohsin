<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seo;

class SeoSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            [
                'page' => 'home',
                'url' => '/',
                'meta_title' => 'Buy Quality Products Online | YourShop',
                'meta_description' => 'Shop the latest products at unbeatable prices. Fast delivery, easy returns, and top-rated customer service.',
                'meta_keywords' => 'online store, buy online, ecommerce, yourshop',
            ],
            [
                'page' => 'shop',
                'url' => '/shop',
                'meta_title' => 'Browse All Products | Shop Now at YourShop',
                'meta_description' => 'Explore all categories and discover top products at affordable prices. Safe checkout and fast delivery guaranteed.',
                'meta_keywords' => 'shop online, categories, buy now, ecommerce deals',
            ],
            [
                'page' => 'product.show',
                'url' => '/product/{id}',
                'meta_title' => 'Product Details & Reviews | YourShop',
                'meta_description' => 'Get detailed information, specifications, and reviews on our best-selling products. Limited stock available!',
                'meta_keywords' => 'product review, item details, features, buy product',
            ],
            [
                'page' => 'about',
                'url' => '/about',
                'meta_title' => 'About Us | Learn About YourShop’s Story',
                'meta_description' => 'We are passionate about delivering quality products at great prices. Learn more about our mission and values.',
                'meta_keywords' => 'about yourshop, company info, ecommerce story',
            ],
            [
                'page' => 'contact',
                'url' => '/contact',
                'meta_title' => 'Contact Us | Get in Touch With YourShop',
                'meta_description' => 'Need help? Reach out to our support team for product inquiries, shipping info, or feedback.',
                'meta_keywords' => 'contact yourshop, support, help, get in touch',
            ],
            [
                'page' => 'cart',
                'url' => '/cart',
                'meta_title' => 'Your Shopping Cart | Review & Checkout',
                'meta_description' => 'Review your selected items and proceed to a secure checkout. Make changes to your cart anytime.',
                'meta_keywords' => 'shopping cart, checkout, order items, ecommerce cart',
            ],
            [
                'page' => 'checkout',
                'url' => '/checkout',
                'meta_title' => 'Secure Checkout | YourShop',
                'meta_description' => 'Fast and secure checkout experience. Enter your shipping and payment details with confidence.',
                'meta_keywords' => 'checkout, payment, order summary, secure payment',
            ],
            [
                'page' => 'checkout.payment',
                'url' => '/checkout/payment',
                'meta_title' => 'Payment Gateway | YourShop Secure Pay',
                'meta_description' => 'Complete your purchase through our secure payment portal. Trusted by thousands of happy customers.',
                'meta_keywords' => 'secure payment, pay online, checkout, ecommerce gateway',
            ],
            [
                'page' => 'payment.success',
                'url' => '/payment/success',
                'meta_title' => 'Order Confirmed | Thank You for Shopping',
                'meta_description' => 'Your order has been successfully placed. We’ll notify you when it’s shipped. Track your order anytime.',
                'meta_keywords' => 'order success, purchase confirmed, thank you, order done',
            ],
            [
                'page' => 'payment.failure',
                'url' => '/payment/failure',
                'meta_title' => 'Payment Failed | Please Try Again',
                'meta_description' => 'There was an issue processing your payment. Please review your details or use a different method.',
                'meta_keywords' => 'payment failed, error, retry payment, checkout issue',
            ],
            [
                'page' => 'refund.request.form',
                'url' => '/refund-request',
                'meta_title' => 'Request a Refund | YourShop Help Center',
                'meta_description' => 'Need a refund? Fill out the refund request form and we’ll process it as soon as possible.',
                'meta_keywords' => 'refund request, return item, money back, request refund',
            ],
        ];

        foreach ($routes as $route) {
            Seo::firstOrCreate(
                ['page' => $route['page']],
                [
                    'meta_title' => $route['meta_title'],
                    'meta_description' => $route['meta_description'],
                    'meta_keywords' => $route['meta_keywords'],
                    'og_title' => $route['meta_title'],
                    'canonical_url' => url($route['url']),
                    'robots' => 'index, follow',
                    'twitter_title' => $route['meta_title'],
                    'og_image' => null,
                    'twitter_image' => null,
                ]
            );
        }
    }
}