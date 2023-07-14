<?php

namespace App\Domains\Stock_Management\Models;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardModel extends Model
{
    use HasFactory;
    public function getTotalWeeklyRequest()
    {
        return DB::table('request_transfers')
            ->select([
                DB::raw('extract(year from request_transfers.created_at) AS year'),
                DB::raw('extract("week" from request_transfers.created_at) AS week'),
                DB::raw('COUNT(request_transfers.request_id) AS total'),
            ])
            ->groupBy([
                DB::raw('extract(year from request_transfers.created_at)'),
                DB::raw('extract(week from request_transfers.created_at)'),
            ])
            ->orderByDesc('year')
            ->orderBy('week');
    }

    /**
     * Get latest weekly delivery.
     *
     * @return Builder
     */
    public function getTotalWeeklyDelivery()
    {
        return DB::table('transfers')
            ->select([
                DB::raw('extract(year from transfers.created_at) AS year'),
                DB::raw('extract(week from transfers.created_at) AS week'),
                DB::raw('COUNT(transfers.transfer_id) AS total'),
            ])
            ->groupBy([
                DB::raw('extract(year from transfers.created_at)'),
                DB::raw('extract(week from transfers.created_at)'),
            ])
            ->orderByDesc('year')
            ->orderBy('week');
    }

    /**
     * Get stock goods weekly
     */
    public function getStockGoods()
    {
        $reportStock = new ReportModel();
        return Collection::times(10)->map(function ($value) use ($reportStock) {
            $stock = $reportStock->getStockGoods(new Request([
                'stock_date' => $date = Carbon::now()->subWeeks($value - 1)
            ]));

            return collect([
                'date' => $date->toDateString(),
                'stocks' => $stock->count()
            ]);
        });
    }
}
