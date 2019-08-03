<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaypalSetting;
use App\Models\TrackingSetting;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $title = '网站设置';

        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data as $key => $value) {
                WebsiteSetting::where('key', $key)->update(['value' => (string) $value]);
            }

            return $this->success('设置成功');
        }

        return view('admin.setting.index', [
            'pageTitle' => $title,
            'data'      => array_pluck(WebsiteSetting::all(), 'value', 'key'),
            'logo'      => WebsiteSetting::getLogo(),
        ]);
    }

    public function paypal(Request $request)
    {
        $title = 'Paypal设置';

        $sandbox = PaypalSetting::find('sandbox');
        $production = PaypalSetting::find('production');

        if ($request->isMethod('post')) {
            $setting = PaypalSetting::firstOrNew(['env' => $request->env]);
            $setting->account = $request->account;
            $setting->client_id = $request->client_id;
            $setting->secret = $request->secret;
            $setting->save();

            return $this->success('设置成功');
        }

        return view('admin.setting.paypal', [
            'pageTitle'  => $title,
            'sandbox'    => $sandbox,
            'production' => $production,
        ]);
    }

    public function tracking(Request $request)
    {
        $title = '快递设置';

        $setting = TrackingSetting::firstOrNew([]);

        if ($request->isMethod('post')) {
            $setting->name = $request->name;
            $setting->address = $request->address;
            $setting->company = $request->company;
            $setting->phone = $request->phone;
            $setting->fax = $request->fax;
            $setting->postcode = $request->postcode;
            $setting->save();

            return $this->success('设置成功');
        }

        return view('admin.setting.tracking', [
            'pageTitle' => $title,
            'setting'   => $setting,
        ]);
    }

    public function terms(Request $request)
    {
        $title = 'Terms and Conditions';

        $terms = WebsiteSetting::where('key', 'terms')->first();
        if (!$terms) {
            $terms = new WebsiteSetting;
            $terms->key = 'terms';
            $terms->value = '';
        }

        if ($request->isMethod('post')) {
            $terms->value = $request->input('terms');
            $terms->save();

            return $this->success('设置成功');
        }

        return view('admin.setting.terms', [
            'pageTitle' => $title,
            'terms'     => $terms->value,
        ]);
    }
}
