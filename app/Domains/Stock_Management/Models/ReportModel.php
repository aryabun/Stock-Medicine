<?php

namespace App\Domains\Stock_Management\Models;

use App\Models\Enumeration\StateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Carbon\Exceptions\ParseErrorException;
use DateTimeInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportModel
{
    use HasFactory;
    /**
     * Get report stock goods.
     *
     * @param Request $request
     * @return Builder
     */
    // pq
        /**
         * Get report stock goods.
         *
         * @param Request $request
         * @return Builder
         */
        public function getStockGoods(Request $request)
        {
            /**
             * Create stock query with minimum group columns,
             * this query will be joined later to get additional data information.
             */
            $stockQuery = DB::table('request_transfers')
            ->select([
                'request_transfers.request_id',
                'transfer_products.product_code',
                DB::raw('SUM(transfer_products.qty) AS bottle_qty'),
                DB::raw('MAX(transfer_products.id) AS latest_transfer_products_id'),
            ])
            ->join('transfers', function (JoinClause $join) {
                $join->on('transfers.request_id', '=', 'request_transfers.request_id')
                    ->where('transfers.status', StateEnum::TRANSFER_DONE);
            })
            // ->join('transfers', 'transfers.request_id', '=', 'request_transfers.request_id')
            ->join('transfer_products', 'transfer_products.transfer_id', '=', 'transfers.transfer_id')
            ->leftJoin('products', 'products.product_code', '=', 'transfer_products.product_code')
            ->leftJoin('product_boxes', 'product_boxes.box_code', '=', 'transfer_products.box_code')
            ->leftJoin('internal_admins', 'internal_admins.code', '=', 'request_transfers.approved_by')
            ->leftJoin('external_admins', 'external_admins.code', '=', 'request_transfers.user_id')
            ->groupBy([
                'request_transfers.request_id',
                'transfer_products.product_code',
                'transfers.transfer_id'
            ]);
        $baseQuery = DB::table('request_transfers')
            ->select([
                'request_transfers.request_id AS request_id',
                'request_transfers.transfer_ref',
                // 'external_admins.customer_name',
                'products.id AS product_id',
                'products.product_code',
                'products.product_name',
                'products.unit',
                'stock_goods.bottle_qty AS bottle_qty',
                'transfers.transfer_id AS latest_job_id',
                'stock_goods.latest_transfer_products_id',
            ])
            ->joinSub($stockQuery, 'stock_goods', function(JoinClause $join) {
                $join->on('request_transfers.request_id', '=', 'stock_goods.request_id');
            })
            ->join('products', 'products.product_code', '=', 'stock_goods.product_code')
            ->join('external_admins', 'external_admins.code', '=', 'request_transfers.user_id')
            ->join('transfer_products', 'transfer_products.id', '=', 'stock_goods.latest_transfer_products_id')
            ->join('product_boxes', 'product_boxes.box_code', '=', 'transfer_products.box_code')
            ->join('transfers', 'transfers.transfer_id', '=', 'transfer_products.transfer_id');
            if ($request->has('q') && $request->filled('q')) {
                $q = trim($request->input('q'), '');
                $baseQuery->where(function (Builder $query) use ($q) {
                    $query->orWhere('transfer_id', 'LIKE', '%' . $q . '%');
                    $query->orWhere('request_id', 'LIKE', '%' . $q . '%');
                    $query->orWhere('customer_name', 'LIKE', '%' . $q . '%');
                    $query->orWhere('product_name', 'LIKE', '%' . $q . '%');
                    $query->orWhere('product_code', 'LIKE', '%' . $q . '%');
                    $query->orWhere('box_code', 'LIKE', '%' . $q . '%');
                });
            }
    
            /**
             * Apply container profile filter
             */
            $this->applyGoodsFilter($baseQuery, $request);
    
            /**
             * Apply owner profile filter
             */
            $this->applyOwnerFilter($baseQuery, $request);

            return $baseQuery;
        }
    
        /**
         * Apply builder general stock filter.
         *
         * @param Builder $stockQuery
         * @param Request $request
         */
        protected function applyStockFilter(Builder $stockQuery, Request $request)
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
                    $stockQuery->having('bottle_qty', '>', '0');
                    break;
                case 'empty-stock':
                    $stockQuery->having('bottle_qty', '=', '0');
                    break;
                case 'negative-stock':
                    $stockQuery->having('bottle_qty', '<', '0');
                    break;
                case 'inactive-stock':
                    $stockQuery->having('bottle_qty', '<=', '0');
                    break;
            }
    
            /**
             * Stock cut by date of the activity
             */
            if ($request->has('stock_date') && $request->filled('stock_date')) {
                $stockDate = $request->input('stock_date');
                if (!$stockDate instanceof DateTimeInterface) {
                    try {
                        $stockDate = Carbon::parse($request->input('stock_date'));
                    } catch (ParseErrorException $e) {
                    }
                }
                $stockQuery->whereDate('request_transfers.received_date', '<=', $stockDate);
            }
        }
    
        /**
         * Apply booking and customer filter.
         *
         * @param Builder $baseQuery
         * @param Request $request
         */
        protected function applyOwnerFilter(Builder $baseQuery, Request $request)
        {
            if ($request->has('user_id') && $request->filled('user_id')) {
                $baseQuery->where('external_admin.code', $request->input('user_id'));
            }
    
            if ($request->has('request_id') && $request->filled('request_id')) {
                $baseQuery->where('request_transfers.request_id', $request->input('request_id'));
            }
        }
    
        /**
         * Apply goods profile filter.
         *
         * @param Builder $baseQuery
         * @param Request $request
         */
        protected function applyGoodsFilter(Builder $baseQuery, Request $request)
        {
            if ($request->has('product_code') && $request->filled('product_code')) {
                $baseQuery->where('products.product_code', $request->input('product_code'));
            }
    
            if ($request->has('box_code') && $request->filled('box_code')) {
                $baseQuery->where('product_boxes.box_code', $request->input('box_code'));
            }
        }
         /**
     * Get stock movement query.
     *
     * @param Request $request
     * @return Builder
     */
    public function getStockMovementGoods(Request $request)
    {
        /**
         * Create stock query with minimum group columns,
         * this query will be joined later to get additional data information.
         */
        $stockQuery = DB::table('request_transfers')
            ->select([
                'request_transfers.request_id',
                'transfers.transfer_id',
                DB::raw("CONCAT(internal_admins.first_name_en,' ',internal_admins.last_name_en) as approver"),
                DB::raw("CONCAT(external_admins.first_name_en,' ',external_admins.last_name_en) as request_by"),
                'request_transfers.received_date',
                'receiveds.received_id',
                'transfer_products.box_code',
                'product_boxes.exp_date',
                'transfer_products.product_code',
                'products.product_code',
                'products.product_name',
                DB::raw('transfer_products.qty AS bottle_qty'),
            ])
            ->join('transfers', function (JoinClause $join) {
                $join->on('transfers.request_id', '=', 'request_transfers.request_id')
                    ->where('transfers.status', StateEnum::TRANSFER_DONE);
            })
            ->join('receiveds', 'receiveds.transfer_id', '=', 'transfers.transfer_id')
            ->join('transfer_products', 'transfer_products.transfer_id', '=', 'transfers.transfer_id')
            ->join('products', 'products.product_code', '=', 'transfer_products.product_code')
            ->join('product_boxes', 'product_boxes.box_code', '=', 'transfer_products.box_code')
            ->leftJoin('internal_admins', 'internal_admins.code', '=', 'request_transfers.approved_by')
            ->leftJoin('external_admins', 'external_admins.code', '=', 'request_transfers.user_id');

        /**
         * Stock cut by date of the activity
         */
        if ($request->has('stock_date') && $request->filled('stock_date')) {
            $stockDate = $request->input('stock_date');
            if (!$stockDate instanceof DateTimeInterface) {
                try {
                    $stockDate = Carbon::parse($request->input('stock_date'));
                } catch (ParseErrorException $e) {
                }
            }
            $stockQuery->whereDate('transfers.created_at', '>=', $stockDate);
        }

        return $stockQuery;
    }


    /**
     * Calculate balance goods.
     *
     * @param Builder $stockMovementQuery
     * @param Builder $stockQuery
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function calculateGoodsBalance(Builder $stockMovementQuery, Builder $stockQuery, Request $request)
    {
        $stocks = $stockQuery->get();
        $stockMovements = $stockMovementQuery->get();

        return $stocks->map(function ($currentStock) use ($stockMovements, $request) {
            if (!$request->has('stock_date') || $request->isNotFilled('stock_date')) {
                $currentStock->bottle_qty = 0;
                $currentStock->balance = 0;
            } else {
                $currentStock->balance = $currentStock->bottle_qty;
            }
            $currentStock->transactions = $stockMovements
                ->map(function ($item) use (&$currentStock) {
                    $item->balance = $currentStock->balance;
                    $item->stock = $item->balance + $item->bottle_qty;
                    $currentStock->balance = $item->stock;

                    return $item;
                });
            return $currentStock;
        });
    }

    
    }