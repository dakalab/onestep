<?php

use App\Models\PaypalSetting;
use Illuminate\Database\Seeder;

class PaypalSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaypalSetting::create([
            'env'       => 'sandbox',
            'account'   => 'hyperjiang-facilitator@gmail.com',
            'client_id' => 'ATvm-tvmW22tdo07hVIRn1zU8AQr_Ud1zaWPVA3YiCdRBDta7a3GC2yJZGAK4IVILMqHDwKxRLjkMjUz',
            'secret'    => 'goto https://developer.paypal.com/developer/applications/',
        ]);

        PaypalSetting::create([
            'env'       => 'production',
            'account'   => 'hyperjiang@gmail.com',
            'client_id' => 'AbRdUQYGBtXXV-egFR4A4k4h0MzXAw4DV79vNcbOHNUwmFBDKW0ncskGaX2Fp28JgGx_ZHK9ogYA70gq',
            'secret'    => 'goto https://developer.paypal.com/developer/applications/',
        ]);
    }
}
