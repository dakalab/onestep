<?php

namespace App\Console\Commands;

use App\Models\PaypalSetting;
use Illuminate\Console\Command;
use PayPal\Api\WebProfile;
use \PayPal\Api\Presentation;

class PaypalProfile extends Command
{
    /**
     * PayPal command line tool
     *
     * @var string
     */
    protected $signature = 'paypal:profile {action=list} {args?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Access paypal web profiles';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        echo $action . "\n";
        try {
            switch ($action) {
                case 'add':
                    $presentation = new Presentation;
                    $presentation->setLogoImage(asset('/img/logo.jpg'));
                    $profile = new WebProfile;
                    $ret = $profile->setName(config('app.domain'))
                        ->setTemporary(false)
                        ->setPresentation($presentation)
                        ->create(PaypalSetting::getApiContext());
                    print_r($ret);
                    break;
                case 'get':
                    $profileId = $this->argument('args');
                    if (empty($profileId)) {
                        $this->error('Please input profile id!');
                        die;
                    }
                    $profile = WebProfile::get($profileId, PaypalSetting::getApiContext());
                    print_r($profile);
                    break;
                case 'del':
                    $profileId = $this->argument('args');
                    if (empty($profileId)) {
                        $this->error('Please input profile id!');
                        die;
                    }
                    $profile = new WebProfile;
                    $profile->setId($profileId)->delete(PaypalSetting::getApiContext());
                    break;
                case 'list':
                default:
                    $profiles = WebProfile::get_list(PaypalSetting::getApiContext());
                    print_r($profiles);
            }
        } catch (\Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
}
