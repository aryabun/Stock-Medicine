<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Models\ReportModel;
use App\Exports\ReportExport;
use App\Exports\ReportYearlyExport;
use App\Models\Enumeration\StateEnum;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ParseErrorException;

class ReportController
{
    public function byWarehouse(Request $request){
        $data  = DB::table('product_boxes')
        ->join('product_lots', 'product_lots.lot_code', '=', 'product_boxes.lot_code')
        ->join('warehouses', 'warehouses.warehouse_code', '=', 'product_lots.warehouse_code')
        ->join('products', 'products.product_code', '=', 'product_boxes.product_code')
        ->where('warehouses.warehouse_code', $request->input('warehouse_code'))
        ->select([
            'product_boxes.product_code',
            'products.product_name',
            DB::raw('SUM(product_boxes.bottle_qty) AS qty')
            ])
        ->groupBy(['products.product_name','product_boxes.product_code'])->get();
        
        return $data;
    }
    public function allProducts(Request $request){
        $stockData = DB::table('products')
        ->select([
            'warehouses.warehouse_code',
            'warehouses.warehouse_name',
            'products.product_code',
            'products.product_name',
            // 'transfer_products.product_code',
            DB::raw('SUM(product_boxes.bottle_qty) AS bottle_qty'),
            // DB::raw('MAX(transfer_products.id) AS latest_transfer_products_id'),
        ])
        ->leftJoin('product_boxes', 'product_boxes.product_code', '=', 'products.product_code')
        ->join('product_lots', 'product_lots.lot_code', '=', 'product_boxes.lot_code')
        ->join('warehouses', 'warehouses.warehouse_code', '=', 'product_lots.warehouse_code')
        ->groupBy([
            'warehouses.warehouse_code',
            'warehouses.warehouse_name',
            'products.product_name',
            'products.product_code',
            // 'bottle_qty'
        ]);
        
        $this->applyStockFilter($stockData, $request);
        if ($request->has('q') && $request->filled('q')) {
            $q = trim($request->input('q'), '');
            $stockData->where('warehouses.warehouse_code', 'LIKE', '%' . $q . '%')
                ->orWhere('products.product_code', 'LIKE', '%' . $q . '%')
                ->orWhere('products.product_name', 'LIKE', '%' . $q . '%');
        }
        if ($request->has('warehouse_code') && $request->filled('warehouse_code')) {
            $q = trim($request->input('warehouse_code'), '');
            $stockData->where('warehouses.warehouse_code', $q);
        }
        return $stockData->paginate();
    }
    protected function applyStockFilter($stockQuery, Request $request)
    {
        /**
         * Determine data of the stock, available options:
         * - all-data: All stock data of booking
         * - stocked: Only available stock (more than 0 qty)
         * - empty-stock: Only zero qty
         * - negative-stock: Only negative stock (needed in take stock feature, checking error)
         * - inactive-stock: Zero and bellow stock
         */
        $stock = $request->input('data', 'stock');
        switch ($stock) {
            case 'all-data':
            case 'all':
                break;
            case 'stocked':
            case 'stock-only':
            case 'stock':
            default:
                $stockQuery->where('bottle_qty', '>', '0');
                break;
            case 'empty-stock':
                $stockQuery->where('bottle_qty', '=', '0');
                break;
            case 'negative-stock':
                $stockQuery->where('bottle_qty', '<', '0');
                break;
            case 'inactive-stock':
                $stockQuery->where('bottle_qty', '<=', '0');
                break;
        }

        /**
         * Stock cut by date of the activity
         */
        if ($request->has('stock_date') && $request->filled('stock_date')) {
            $stockDate = $request->input('stock_date');
            $stockQuery->whereDate('request_transfers.received_date', '<=', $stockDate);
        }
    }
    public function getStockMovementGoods(Request $request)
    {
        /**
         * Create stock query with minimum group columns,
         * this query will be joined later to get additional data information.
         */
        $stockQuery = DB::table('request_transfers')
            ->select([
                'request_transfers.request_id',
                'request_transfers.transfer_ref',
                DB::raw("CONCAT(internal_admins.first_name_en,' ',internal_admins.last_name_en) as approver"),
                DB::raw("CONCAT(external_admins.first_name_en,' ',external_admins.last_name_en) as request_by"),
                // 'receiveds.received_id',
                'request_transfers.received_date',
                // 'request_transfers.from_warehouse',
                'transfer_products.box_code',
                'request_transfers.approved_date',
                'transfers.created_at as transit_date',
                'request_transfers.received_date',
                'toWH.warehouse_name as to_warehouse_name',
                'fromWH.warehouse_name as from_warehouse_name',
                DB::raw('transfer_products.qty AS bottle_qty'),
                'product_boxes.exp_date as product_exp_date',
                'transfer_products.product_code',
                'products.product_code',
                'products.product_name',
                DB::raw('transfer_products.qty AS bottle_qty'),
            ])
            ->leftjoin('warehouses as toWH', 'toWH.warehouse_code', '=', 'request_transfers.to_warehouse')
            ->leftjoin('warehouses as fromWH', 'fromWH.warehouse_code', '=', 'request_transfers.from_warehouse')
            ->join('transfers', function (JoinClause $join) {
                $join->on('transfers.request_id', '=', 'request_transfers.request_id')
                    ->where('transfers.status', StateEnum::TRANSFER_DONE);
            })
            ->join('transfer_products', 'transfer_products.transfer_id', '=', 'transfers.transfer_id')
            ->join('products', 'products.product_code', '=', 'transfer_products.product_code')
            ->join('product_boxes', 'product_boxes.box_code', '=', 'transfer_products.box_code')
            ->leftJoin('internal_admins', 'internal_admins.code', '=', 'request_transfers.approved_by')
            ->leftJoin('external_admins', 'external_admins.code', '=', 'request_transfers.user_id');

        /**
         * Stock cut by date of the activity
         */
        // if ($request->has('stock_date') && $request->filled('stock_date')) {
        //     $stockDate = $request->input('stock_date');
        //     if (!$stockDate instanceof DateTimeInterface) {
        //         try {
        //             $stockDate = Carbon::parse($request->input('stock_date'));
        //         } catch (ParseErrorException $e) {
        //         }
        //     }
        //     $stockQuery->whereDate('transfers.created_at', '>=', $stockDate);
        // }

        return $stockQuery->get();
    }
    public function stockSummary(Request $request, ReportModel $report)
    {
        $goodsRequest = $request->get('filter') == 'products' ? $request : new Request();

        $stockGoods = $report->getStockGoods($goodsRequest);

        return response()->json([
            'data' => [
                'products' => $stockGoods->paginate(),
            ]
        ]);
    }

    // /**
    //  * Show stock report movement.
    //  *
    //  * @param Request $request
    //  * @param ReportModel $reportStockMovement
    //  * @param ReportModel $reportStock
    //  * @return JsonResponse
    //  */
    // public function stockMovement(Request $request, ReportModel $reportStock)
    // {
    //     if ($request->has('request_id') && $request->filled('request_id')) {
    //         $stockGoods = $reportStock->getStockGoods($request->merge(['data' => 'all']));

    //         $stockMovementGoods = $reportStock->getStockMovementGoods($request);
    //         // $goods = $reportStock->calculateGoodsBalance($stockMovementGoods, $stockGoods, $request);
    //     }
    //     return response()->json([
    //         'data' => $reportStock->getStockGoods($request->merge(['data' => 'all']))
    //     ]);
    // }
    public function yearlyReport(Request $request){
        $stockData = DB::table('transfer_products')
        ->select([
            'transfer_products.product_code',
            'products.product_name',
            DB::raw('SUM(transfer_products.qty) AS transfer_qty'),
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
        ])->get();
        return $stockData;
        
    }
    public function yearlyExportAll(){
        return (new ReportYearlyExport)->download('distributed_all.csv');
    }
    public function yearlyExport($year){
        return (new ReportExport($year))->download('invoices.csv');
    }
}
