<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Http\Resources\StockDataResource;
use App\Domains\Stock_Management\Models\ProductBox;
use App\Domains\Stock_Management\Models\StockData;
use Illuminate\Http\Request;

class StockDataController
{
    /**
     * Display a listing of the resource.
     */
    public function available_stock(Request $request)
    {
        // Groupby Product Code from model Box
        ProductBox::groupBy('product_code')
            ->selectRaw('sum(bottle_qty) as sum, product_code') //Calculate sum of the bottle qty in box
            ->get()
            ->map(function($item){
                // Store data to current stock with product code
                return StockData::updateOrCreate(
                    ['product_code' => $item->product_code],
                    ['current_stock' => $item->sum]);
            });
        if($request->has('product_code')){
            $products = StockData::where('product_code', $request->product_code)->get();
        }else{
            //Using filter and sorting data and paginate  
            $products = StockData::q($request->get('q'))
                        ->sort($request->get('sort_by'), $request->get('sort_method'))
                        ->dateFrom($request->get('date_from'))
                        ->dateTo($request->get('date_to'))
                        ->paginate();
        }
        return response()->json(StockDataResource::collection($products));
    }
    public function check_availability(){
        $data = ProductBox::leftJoin('product_lots','product_lots.lot_code', '=', 'product_boxes.lot_code')
        ->leftJoin('products','products.product_code', '=', 'product_boxes.product_code')
        ->where('warehouse_code', 'HEADQUARTER')
        ->get();
        // $sum = ProductBox::groupBy('product_code')
        // ->selectRaw('sum(bottle_qty) as sum, product_code') //Calculate sum of the bottle qty in box
        // ->get();

        // $customer= $customer->map(function ($item, $key) {
        //     $single_agent = $agent->where('agent_allocated_date',$item->agent_allocated_date);
        //     return collect($item)->merge($single_agent);
        // });
        return $data;
    }
    public function data()
    {
        return ProductBox::with('lot')->get();
    }
}
