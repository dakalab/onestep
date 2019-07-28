<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(WebsiteSettingsTableSeeder::class);
        $this->call(PageCategoriesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
    }
}
