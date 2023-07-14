<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
// use App\Domains\Stock_Management\External\Models\Product;
use App\Domains\Stock_Management\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = [
            [
                'product_name' => 'Metformin',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '500 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Amlodipine',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '5 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Atenolol',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '5 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Enalapril',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '10 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Hydralazine',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '25 mg ',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Hydrochlorothiazide(25 mg)',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '25 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Hydrochlorothiazide(50 mg)',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '50 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Methyldopa',
                'description' => 'For use only in the management of pregnancy-induced hypertension',
                'unit' => 'Bottle',
                'strength' => '250 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Nifedipine(20 mg)',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '20 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],
            [
                'product_name' => 'Nifedipine(10 mg)',
                'description' => '',
                'unit' => 'Bottle',
                'strength' => '10 mg',
                'med_type' => 'Tablet',
                'disease_type' => 'Hypertension',
                'status' => true, 
            ],


        ];
        foreach($product as $products){

            Product::create($products);
        }
          
    }
}
