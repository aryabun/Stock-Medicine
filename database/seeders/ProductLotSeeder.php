<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Stock_Management\Models\ProductLot;

class ProductLotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lot = [
            [
                'warehouse_code' => 'HEADQUARTER',
            ],
            [
                'warehouse_code' => 'HEADQUARTER',
            ],
            [
                'warehouse_code' => 'HEADQUARTER',
            ],
            [
                'warehouse_code' => 'HEADQUARTER',
            ],
            [
                'warehouse_code' => 'HEADQUARTER',
            ],
        ];
        foreach($lot as $lot_data){
            ProductLot::create($lot_data);
        }
    }
}
