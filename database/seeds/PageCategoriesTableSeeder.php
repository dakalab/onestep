<?php

use App\Models\PageCategory;
use Illuminate\Database\Seeder;

class PageCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Company information',
            'Customer service',
        ];
        foreach ($data as $name) {
            $category = new PageCategory;
            $category->name = $name;
            $category->save();
        }
    }
}
