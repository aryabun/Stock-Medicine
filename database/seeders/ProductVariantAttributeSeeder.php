<?php

namespace Database\Seeders;

use App\Domains\Stock_Management\Models\ProductVariantAttribute;
use Illuminate\Database\Seeder;

class ProductVariantAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $attribute = [
            [
                'attribute' => 'Color',
            ],
            [
                'attribute' => 'Shape',
            ],
        ];
        foreach($attribute as $attributes){
            ProductVariantAttribute::create($attributes);
        }
    }
}
