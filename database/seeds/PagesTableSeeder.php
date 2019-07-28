<?php

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'service@' . config('app.domain');
        $data = [
            [
                'page_category_id' => 1,
                'title'            => 'About Us',
                'seo_url'          => 'about.html',
                'user_id'          => 1,
            ],
            [
                'page_category_id' => 1,
                'title'            => 'Contact Us',
                'seo_url'          => 'contact.html',
                'user_id'          => 1,
            ],
            [
                'page_category_id' => 1,
                'title'            => 'Shipping & Return',
                'seo_url'          => 'freeshipping.html',
                'user_id'          => 1,
                'content'          => "<p><strong>Free Shipping</strong></p>

                <p>Free Shipping is available for all places. Just order, receive and enjoy your product in style.</p>

                <p>&nbsp;</p>

                <p><strong>100% Customer Service Satisfaction</strong></p>

                <p>Enjoy comprehensive warranties including a 30 day no-questions-asked money back guarantee.We take your satisfaction seriously. We provide a professional, dedicated service for every single customer regardless of order size. Our Support Center replies to your support tickets quickly, if you have any questions or want faster delivery, please send email to <strong>$email</strong>.</p>

                <p>&nbsp;</p>

                <p><strong>Warranty and Return</strong></p>

                <p>We want you to love our products as much as we do. All items we ship have successfully passed our rigorous Quality Control inspections. Our warranties ensure you have a fantastic gadget experience while giving you total peace of mind. Most items are covered by the following comprehensive product warranties. If, in an unlikely situation you are not covered, please check our&nbsp;<strong>Warranty Exemptions and Notes</strong> below.</p>

                <p>&nbsp;</p>

                <p><strong>7-15 Days Dead on Arrival (DOA) Guarantee</strong></p>

                <p>If your item arrives damaged or is not working, please follow the warranty process and send email to <strong><a href=\"mailto:$email\">$email</a></strong> for RMA authorization within 7-15 days of the order being received. After returning the product to us, we can send you a new item free of charge (we will reimburse you the return shipping cost), or you can choose to receive a full refund. Enjoy total peace of mind: every single purchase is 100% risk-free each time.</p>

                <p>&nbsp;</p>

                <p><strong>Special Notes:</strong></p>

                <p>1. Customers must first send a clear photo or video of the damaged or defective product and the shipping packaging before we can consider issuing RMA authorization. Please use good lighting, and a close to medium distance, so we can identify and verify the issue(s). And please send email with attachments to: <strong><a href=\"mailto:$email\">$email</a></strong>.<br />
                2. After we has received the returned product and confirmed the product is faulty, the return shipping cost will be refunded based on a valid return receipt. For example if the return shipping fee is 30 USD, we will refund the same amount of 30 USD to the customer. If our technical team determines the item is not DOA , we will not compensate the return shipping fee. Refund requests for a return shipping fee without a valid RMA return receipt slip will not be accepted.<br />
                3. Product returns must be via one of our approved shipping methods; our Support Center can provide you with further details.</p>

                <p>&nbsp;</p>

                <p><strong>30 Day Unconditional Refund Guarantee for Unopened &amp; Unused Items</strong></p>

                <p>If for whatever reason you do not want your item within 30 days of receiving it, you may also contact us for a return and refund. Kindly note that in such cases the return shipping fee is the customers responsibility and is non-refundable. Items MUST be returned in their original packaging, unused and unopened in order to qualify for a product refund.</p>",
            ],
            [
                'page_category_id' => 2,
                'title'            => 'Order History',
                'seo_url'          => 'account/orders',
                'user_id'          => 1,
            ],
            [
                'page_category_id' => 2,
                'title'            => 'Wish List',
                'seo_url'          => 'account/wishlist',
                'user_id'          => 1,
            ],
            [
                'page_category_id' => 2,
                'title'            => 'Address Book',
                'seo_url'          => 'account/address',
                'user_id'          => 1,
            ],
            [
                'page_category_id' => 2,
                'title'            => 'Privacy Notice',
                'seo_url'          => 'privacynotice.html',
                'user_id'          => 1,
                'content'          => '<p>ac-power-adapter.co.uk&nbsp;knows that you care how information about you is used and shared, and we appreciate your trust that we will do so carefully and sensibly. This notice describes our privacy policy. By visiting adapters-store.co.uk, you are accepting the practices described in this Privacy Notice.</p>

                <p>What information do we collect and how do we use it?</p>

                <p>When you order, we need to know:</p>

                <p>Your name</p>

                <p>Mailing&nbsp;address</p>

                <p>Your Email</p>

                <p>This information allows us to process and fulfill your order and to notify you of your order status and any problems. When you sign up for services like Newsletters we need only an email address -- which we use to send the information you requested.</p>

                <p>We may personalize your shopping experience by using your purchases and site behavior to shape our recommendations about products and other merchandise that might be of interest to you. We also monitor customer traffic patterns and site usage to help us develop the design and layout of the site. We may also use the information we collect to occasionally notify you about important functionality changes to the web site, new services, and special offers we think you will find of value.</p>

                <p>We use Paypal to process our credit card payments. They use the latest encryption technology to keep your information safe. We understand your concerns about Internet security.</p>

                <p>When you place your order with us online, your credit card information is transmitted across the Internet in an encrypted (scrambled) form. We never see your card number, we do not hold any credit card information on file, your account is safe against unauthorized 3rd party access and tampering.</p>',
            ],
            [
                'page_category_id' => 2,
                'title'            => 'Conditions of Use',
                'seo_url'          => 'conditions.html',
                'user_id'          => 1,
                'content'          => '<p>The following terms and conditions apply to all transactions made through this website. Please read the following terms and conditions carefully before accessing or purchasing in this website as no other terms apply. By using or accessing this website, you acknowledge that you have read and agree to these terms.</p>

                <p><b>Disclaimer and Limitation of Liability to the Website</b></p>

                <p>Our website and the materials herein are provided as they are. We make no representations or warranties, either expressed or implied, of any kind with respect to our website, our operation, contents, information and materials. We expressly disclaim all warranties, expressed or implied, of any kind with respect to the website or its use, including but not limited to the merchantability and fitness for a particular purpose. Your agree that our website, its directors, officers, employees or other representatives are not liable for damages arising from the operation, content or use of the website. You agree that this limitation of liability is comprehensive and applies to all damages of any kind, including without limitation direct, indirect, compensatory, special, incidental, punitive and consequential damages.</p>

                <p><b>Disclaimer and Limitation of Liability to Products sold</b></p>

                <p>All of our products are guaranteed against defects for 30 days from the date of delivery. Except as expressly stated herein, we make no representations or warranties, either expressed or implied, of any kind with respect to the products sold in this website. Except as expressly stated herein, we expressly disclaim all warranties, expressed or implied, of any kind with respect to the products sold on this website, including but not limited to, the merchantability and fitness for a particular purpose. You agree that the sole and exclusive maximum liability to our website arising from any product sold on the web site is the price of the product(s) ordered. In no event are our website, its directors, officers, employees, and representatives liable for special, indirect, consequential, or punitive damages related to the product(s) sold.</p>

                <p>The products supplied by our Company are sold for use with certain products of computer manufacturers, and any reference to products or trademarks of such companies is purely for the purpose of identifying the computers with which our products may be used. Our Company and this Web site are neither affiliated with, authorized by, licensed by, distributors for, nor related in any way to these computer manufacturers, nor are the products offered for sale through our web site manufactured by or sold with the authorization of the manufacturers of the computers with which our products may be used.</p>

                <p><b>Use</b></p>

                <p>We grant you the permission to view this website for your own personal use provided that you agree to and accept without modification the notices, and conditions set forth in the &#39;Terms and Conditions&#39;. The terms and conditions herein may not be altered, supplemented, or amended by the use of any additional documents that purport to be an agreement of the parties. Any attempt to supplement or amend this document in order to place an order for any product(s) that is/are subjected to the additional or altered terms and conditions will be considered null and void.</p>

                <p><b>Errors and Mistakes Handling</b></p>

                <p>While we strive to provide an error-free website, we cannot guarantee that all contents herein are 100% accurate and/or complete, including prices, product information, product specifications and product compatibility. As such, we reserve the right to correct errors in prices as they are discovered, revoke any stated offers and otherwise correct any errors, inaccuracies, or omissions. The right extends to orders that have already been submitted and accepted by our website.</p>

                <p><b>Trademarks</b></p>

                <p>The trademarks, used and displayed on this Site are registered and unregistered trademarks of the suppliers and manufacturers of the products offered for sale in this website. Nothing contained within this website should be considered as granting any right to use any trademark displayed in the website, without the prior written permission of the trademark owner.</p>

                <p><b>General</b></p>

                <p>We reserve the right to change the terms, conditions, and notices under which this website is offered without notice at any time.</p>

                <p>You hereby agree that no joint venture, partnership, employment, or agency relationship exists between you and our website as a result of this agreement or your use of this website.</p>

                <p>This agreement supersedes all prior or contemporaneous communications and proposals, whether electronics, oral or verbal, between you and our website with respect to this website.</p>',
            ],
            [
                'page_category_id' => 2,
                'title'            => 'Sitemap',
                'seo_url'          => 'sitemap',
                'user_id'          => 1,
            ],
        ];
        foreach ($data as $row) {
            Page::create($row);
        }
    }
}
