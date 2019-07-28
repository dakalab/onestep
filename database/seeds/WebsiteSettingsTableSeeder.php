<?php

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WebsiteSetting::create([
            'key'   => 'site_name',
            'value' => config('app.name'),
        ]);

        WebsiteSetting::create([
            'key'   => 'address',
            'value' => 'China',
        ]);

        WebsiteSetting::create([
            'key'   => 'phone',
            'value' => '13800138000',
        ]);

        WebsiteSetting::create([
            'key'   => 'email',
            'value' => 'hyperjiang@gmail.com',
        ]);

        WebsiteSetting::create([
            'key'   => 'logo',
            'value' => '',
        ]);

        WebsiteSetting::create([
            'key'   => 'logo_style',
            'value' => 'max-width:400px; max-height:40px;',
        ]);

        WebsiteSetting::create([
            'key'   => 'navbar_color',
            'value' => '1',
        ]);

        WebsiteSetting::create([
            'key'   => 'terms',
            'value' => "<p>The following terms and conditions apply to all transactions made through this website. Please read the following terms and conditions carefully before accessing or purchasing in this website as no other terms apply. By using or accessing this website, you acknowledge that you have read and agree to these terms.</p>

            <p><b>Disclaimer and Limitation of Liability to the Website</b></p>

            <p>Our website and the materials herein are provided as they are. We make no representations or warranties, either expressed or implied, of any kind with respect to our website, our operation, contents, information and materials. We expressly disclaim all warranties, expressed or implied, of any kind with respect to the website or its use, including but not limited to the merchantability and fitness for a particular purpose. Your agree that our website, its directors, officers, employees or other representatives are not liable for damages arising from the operation, content or use of the website. You agree that this limitation of liability is comprehensive and applies to all damages of any kind, including without limitation direct, indirect, compensatory, special, incidental, punitive and consequential damages.</p>

            <p><b>Disclaimer and Limitation of Liability to Products sold</b></p>

            <p>All of our products are guaranteed against defects for 30 days from the date of delivery. Except as expressly stated herein, we make no representations or warranties, either expressed or implied, of any kind with respect to the products sold in this website. Except as expressly stated herein, we expressly disclaim all warranties, expressed or implied, of any kind with respect to the products sold on this website, including but not limited to, the merchantability and fitness for a particular purpose. You agree that the sole and exclusive maximum liability to our website arising from any product sold on the web site is the price of the product(s) ordered. In no event are our website, its directors, officers, employees, and representatives liable for special, indirect, consequential, or punitive damages related to the product(s) sold.</p>

            <p>The products supplied by our Company are sold for use with certain products of computer manufacturers, and any reference to products or trademarks of such companies is purely for the purpose of identifying the computers with which our products may be used. Our Company and this Web site are neither affiliated with, authorized by, licensed by, distributors for, nor related in any way to these computer manufacturers, nor are the products offered for sale through our web site manufactured by or sold with the authorization of the manufacturers of the computers with which our products may be used.</p>

            <p><b>Use</b></p>

            <p>We grant you the permission to view this website for your own personal use provided that you agree to and accept without modification the notices, and conditions set forth in the 'Terms and Conditions'. The terms and conditions herein may not be altered, supplemented, or amended by the use of any additional documents that purport to be an agreement of the parties. Any attempt to supplement or amend this document in order to place an order for any product(s) that is/are subjected to the additional or altered terms and conditions will be considered null and void.</p>

            <p><b>Errors and Mistakes Handling</b></p>

            <p>While we strive to provide an error-free website, we cannot guarantee that all contents herein are 100% accurate and/or complete, including prices, product information, product specifications and product compatibility. As such, we reserve the right to correct errors in prices as they are discovered, revoke any stated offers and otherwise correct any errors, inaccuracies, or omissions. The right extends to orders that have already been submitted and accepted by our website.</p>

            <p><b>Trademarks</b></p>

            <p>The trademarks, used and displayed on this Site are registered and unregistered trademarks of the suppliers and manufacturers of the products offered for sale in this website. Nothing contained within this website should be considered as granting any right to use any trademark displayed in the website, without the prior written permission of the trademark owner.</p>

            <p><b>General</b></p>

            <p>We reserve the right to change the terms, conditions, and notices under which this website is offered without notice at any time.</p>

            <p>You hereby agree that no joint venture, partnership, employment, or agency relationship exists between you and our website as a result of this agreement or your use of this website.</p>

            <p>This agreement supersedes all prior or contemporaneous communications and proposals, whether electronics, oral or verbal, between you and our website with respect to this website.</p>
            ",
        ]);
    }
}
