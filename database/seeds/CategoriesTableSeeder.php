<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Awesome',
        ];
        foreach ($data as $name) {
            $category = new Category;
            $category->name = $name;
            $category->save();
        }
    }
}
