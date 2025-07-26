<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pages')->delete();
        
        \DB::table('pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => 'privacy-policy',
                'name' => 'Privacy Policy ',
            'content' => '<p><strong>Effective Date:</strong> [5-14-2025]<br><br>Welcome to <a href="https://toptrendsuk.store/"><strong>Toptrendsuk</strong></a>. We value your trust and are committed to protecting your personal information.<br>This Privacy Policy explains how we collect, use, and protect your information when you visit our website and make a purchase.<br><br><strong>Information We Collect:</strong><br> <strong>• Personal Data:</strong> Name, email address, shipping address, billing address, phone number.<br> <strong>• Payment Information:</strong> We process payments securely through third-party gateways. We do not store your payment details.<br> <strong>• Website Usage Data:</strong> IP address, browser type, device information, and pages visited.<br><br><strong>How We Use Your Information:</strong><br> • To process your orders and deliver products.<br> • To improve your shopping experience.<br> • To send order updates and promotional offers (only if you opt-in).<br> • To respond to your queries and provide customer support.<br><br><strong>Data Protection:</strong><br><br>We implement strict security measures to protect your personal data against unauthorized access or disclosure.<br><br><strong>Sharing Information:</strong><br><br>We do not sell, trade, or rent your personal information.<br>We may share limited information with trusted partners who assist in shipping and payment processing.<br><br><strong>Your Rights:</strong><br> • You can request access, update, or delete your personal information.<br> • You can opt out of marketing emails anytime.<br><br><strong>Cookies:</strong><br><br>Our website uses cookies to enhance browsing and improve site performance. You can manage cookies through your browser settings.<br><br><strong>Contact Us:</strong><br><br>If you have any questions about this Privacy Policy, please get in touch with us at:<br><strong>Email:</strong> <a href="support@toptrendsuk.com">support@toptrendsuk.com</a></p>',
                'created_at' => '2025-05-14 20:17:48',
                'updated_at' => '2025-05-14 20:17:48',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'slug' => 'refund-return-policy',
                'name' => 'Refund & Return Policy',
                'content' => '<p>Effective Date: [5-14-2025]<br><br>At <a href="https://toptrendsuk.store/"><strong>Toptrendsuk</strong></a>, customer satisfaction is our priority. If you are not fully satisfied with your purchase, we are here to help.<br><br><strong>Returns:</strong><br> • You can request a return within 7 days of receiving your order.<br> • Items must be unused, unopened, and in original packaging.<br> • We reserve the right to deny returns if the product shows signs of use or tampering.<br><br><strong>Refunds:</strong><br> • Once we receive and inspect your return, we will notify you.<br> • Approved refunds will be processed to your original payment method within 5-7 business days.<br> • Shipping charges are non-refundable.<br><br><strong>Exchanges:</strong><br><br>We replace products only if they are defective or damaged upon arrival.<br>To request an exchange, please email us with your order number and photos of the damage.<br><br><strong>Non-Returnable Items:</strong><br> • Opened or used perfumes.<br> • Sale items and promotional offers.<br><br><strong>Shipping for Returns:</strong><br><br>Customers are responsible for return shipping costs unless the return is due to a mistake on our part.<br><br><strong>Contact Us:<br></strong><br>For return or refund requests, please email:<br><a href="support@toptrendsuk.com">support@toptrendsuk.com</a></p>',
                'created_at' => '2025-05-14 20:19:35',
                'updated_at' => '2025-05-14 20:19:35',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}