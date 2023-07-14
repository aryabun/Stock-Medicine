<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportYearlyExport implements FromQuery, WithHeadings
{
    use Exportable;
    public function query()
    {
        //
        return DB::table('transfer_products')
        ->select([
            'transfer_products.product_code',
            'products.product_name',
            DB::raw('SUM(transfer_products.qty) AS transfer_qty'),
            'transfer_products.unit',
            DB::raw('extract(year from transfer_products.created_at) as year'),
        ])
        ->leftJoin('products', 'products.product_code', '=', 'transfer_products.product_code')
        ->leftJoin('product_boxes', 'product_boxes.product_code', '=', 'products.product_code')
        ->groupBy([
            'products.product_name',
            'transfer_products.product_code',
            'transfer_products.unit',
            'year',
        ])->orderBy('products.product_name', 'asc');
    }
    public function headings(): array
    {
        return ["product_code", "product_name", "tansfer_qty", "unit", "year"];
    }
}
