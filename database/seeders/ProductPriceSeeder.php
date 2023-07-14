<?php

namespace Database\Seeders;

use App\Domains\Stock_Management\Models\ProductPrice;
use Illuminate\Database\Seeder;

class ProductPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $price = [
            [
                'role_id' => '2',
                'product_code' =>'P00001',
                'value' =>'15'
            ],
            [
                'role_id' => '3',
                'product_code' =>'P00001',
                'value' =>'11'
            ],
            [
                'role_id' => '2',
                'product_code' =>'P00002',
                'value' =>'10'
            ],
            [
                'role_id' => '3',
                'product_code' =>'P00002',
                'value' =>'7'
            ],
            [
                'role_id' => '2',
                'product_code' =>'P00003',
                'value' =>'8'
            ],
            [
                'role_id' => '3',
                'product_code' =>'P00003',
                'value' =>'5'
            ],

        ];
        foreach($price as $prices){
            ProductPrice::create($prices);
        }
    }
}
