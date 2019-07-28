<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalSetting extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'env';

    public static function env($env)
    {
        static $config;

        if (empty($config[$env])) {
            $config[$env] = self::find($env);
        }

        return $config[$env];
    }

    /**
     * Helper method for getting an APIContext for all calls
     *
     * @return PayPal\Rest\ApiContext
     */
    public static function getApiContext()
    {
        $setting = self::env(config('paypal.env'));

        // ### Api context
        // Use an ApiContext object to authenticate
        // API calls. The clientId and clientSecret for the
        // OAuthTokenCredential class can be retrieved from
        // developer.paypal.com
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $setting->client_id,
                $setting->secret
            )
        );

        $mode = config('paypal.env');
        if (config('paypal.env') == 'production') {
            $mode = 'live';
        }

        // based configuration
        $apiContext->setConfig(
            [
                'mode'           => $mode,
                'log.LogEnabled' => true,
                'log.FileName'   => storage_path('logs/paypal.log'),
                'log.LogLevel'   => config('paypal.log_level'), // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled'  => false,
                // 'cache.FileName' => storage_path('logs/paypal.auth.cache'), // for determining paypal cache directory
                // 'http.CURLOPT_CONNECTTIMEOUT' => 30
            ]
        );

        return $apiContext;
    }
}
