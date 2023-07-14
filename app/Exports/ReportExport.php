<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ToArray;

class ReportExport implements FromQuery
{
    use Exportable;

    protected $year;
    public function __construct(int $year)
    {
        $this->year = $year;
    }

    public function query()
    {
        return DB::table('transfer_products')
        ->select([
            'transfer_products.product_code',
            'products.product_name',
            DB::raw('SUM(transfer_products.qty) AS qty'),
            'transfer_products.unit',
            // 'transfer_products.product_code',
            DB::raw('extract(year from transfer_products.created_at) as year'),
            // DB::raw('MAX(transfer_products.id) AS latest_transfer_products_id'),
        ])
        ->leftJoin('products', 'products.product_code', '=', 'transfer_products.product_code')
        ->leftJoin('product_boxes', 'product_boxes.product_code', '=', 'products.product_code')
        // ->join('product_lots', 'product_lots.lot_code', '=', 'product_boxes.lot_code')
        // ->join('warehouses', 'warehouses.warehouse_code', '=', 'product_lots.warehouse_code')
        ->groupBy([
            'year',
            'products.product_name',
            'transfer_products.product_code',
            'transfer_products.unit',
            // 'bottle_qty'
        ])->whereYear('transfer_products.created_at', $this->year)->orderBy('products.product_name', 'asc');
        
    }
}
