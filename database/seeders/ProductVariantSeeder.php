<?php

namespace Database\Seeders;

use App\Domains\Stock_Management\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $variant = [

            [
                'product_code' => 'P00002',
                'attribute_id' => 1,
                'value_id' => 1,
            ],
            [
                'product_code' => 'P00001',
                'attribute_id' => 1,
                'value_id' => 3,
            ],
            [
                'product_code' => 'P00003',
                'attribute_id' => 1,
                'value_id' => 2,
            ],
            [
                'product_code' => 'P00004',
                'attribute_id' => 1,
                'value_id' => 2,
            ],
            [
                'product_code' => 'P00005',
                'attribute_id' => 1,
                'value_id' => 2,
            ],
            [
                'product_code' => 'P00006',
                'attribute_id' => 1,
                'value_id' => 2,
            ],
        ];
        foreach($variant as $variants){
            ProductVariant::create($variants);
        }
    }
}
