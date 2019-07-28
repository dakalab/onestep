<?php

use App\Models\Attribute;
use App\Models\AttributeGroup;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = new AttributeGroup;
        $group->name = 'Color';
        $group->save();

        $colors = [
            'Black',
            'White',
            'Red',
            'Blue',
            'Green',
            'Yellow',
            'Orange',
            'Purple',
            'Gold',
            'Silver',
            'Dark Grey',
            'Rose Gold',
        ];
        foreach ($colors as $color) {
            $attribute = new Attribute;
            $attribute->name = $color;
            $attribute->attribute_group_id = $group->id;
            $attribute->save();
        }
    }
}
