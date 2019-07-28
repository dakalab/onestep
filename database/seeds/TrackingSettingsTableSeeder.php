<?php

use App\Models\TrackingSetting;
use Illuminate\Database\Seeder;

class TrackingSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrackingSetting::create([
            'name'     => config('app.name'),
            'address'  => 'China',
            'company'  => config('app.name'),
            'phone'    => '13800138000',
            'fax'      => '',
            'postcode' => '518000',
        ]);
    }
}
