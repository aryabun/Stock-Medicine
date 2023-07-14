<?php

namespace Database\Seeders;

use App\Domains\Stock_Management\Models\Warehouse;
use Illuminate\Database\Seeder;
use Str;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $warehouse =[ 
            [
                'warehouse_code' => 'HEADQUARTER',
                'warehouse_name' => 'HEADQUARTER',
                'hospital_id' => '',
                'level' => '0', 
                'province_id' => '12',
                'district_id' => '1201',
                'commune_id' => '120102',
            ],
        ];
        foreach($warehouse as $data){
            Warehouse::create($data);
        }
    }
}
