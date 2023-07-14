<?php

namespace Database\Seeders;

use App\Domains\Stock_Management\Models\ProductVariantAttributeValue;
use Illuminate\Database\Seeder;

class ProductVariantAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $value = [
            [
                'attribute_id' => '1',
                'value' => 'Red',
                'status' => true,
            ],
            [
                'attribute_id' => '1',
                'value' => 'Peach',
                'status' => true,
            ],
            [
                'attribute_id' => '1',
                'value' => 'Green',
                'status' => true,
            ],
            [
                'attribute_id' => '2',
                'value' => 'Round',
                'status' => true,
            ],
            [
                'attribute_id' => '2',
                'value' => 'Oval',
                'status' => true,
            ],
        ];
        foreach($value as $values){
            ProductVariantAttributeValue::create($values);
        }
    }
}
