<?php

namespace Database\Seeders;

use App\Domains\Stock_Management\Models\ProductBox;
use Illuminate\Database\Seeder;

class ProductBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $box_data = [
            [
                'product_code' => 'P00001',
                'lot_code' => 'Lot0001',
                'bottle_qty' => 10,
                'qty_per_bottle' => 100,
                'unit' => 'Box',
                'status' => true,
                'exp_date' => '2023-08-20',
            ],
            [
                'product_code' => 'P00002',
                'lot_code' => 'Lot0001',
                'bottle_qty' => 10,
                'qty_per_bottle' => 100,
                'unit' => 'Box',
                'status' => true,
                'exp_date' => '2024-04-15',
            ],
            [
                'product_code' => 'P00002',
                'lot_code' => 'Lot0002',
                'bottle_qty' => 10,
                'qty_per_bottle' => 100,
                'unit' => 'Box',
                'status' => true,
                'exp_date' => '2023-12-30',
            ],
            [
                'product_code' => 'P00003',
                'lot_code' => 'Lot0001',
                'bottle_qty' => 10,
                'qty_per_bottle' => 100,
                'unit' => 'Box',
                'status' => true,
                'exp_date' => '2025-10-05',
            ],
            [
                'product_code' => 'P00004',
                'lot_code' => 'Lot0001',
                'bottle_qty' => 10,
                'qty_per_bottle' => 100,
                'unit' => 'Box',
                'status' => true,
                'exp_date' => '2023-06-10',
            ],
            [
                'product_code' => 'P00005',
                'lot_code' => 'Lot0001',
                'bottle_qty' => 0,
                'qty_per_bottle' => 100,
                'unit' => 'Box',
                'status' => false,
                'exp_date' => '2023-07-15',
            ],
            [
                'product_code' => 'P00006',
                'lot_code' => 'Lot0001',
                'bottle_qty' => 10,
                'qty_per_bottle' => 100,
                'unit' => 'Box',
                'status' => true,
                'exp_date' => '2024-07-12',
            ],
        ];
        foreach($box_data as $data){
            ProductBox::create($data);
        }
    }
}
