<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@' . preg_replace('/https?:\/\//', '', env('APP_URL'));
        $user->password = bcrypt('admin123');
        $user->api_token = bcrypt($user->email);
        $user->is_admin = 1;
        $user->save();
    }
}
