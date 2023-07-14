<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Http\Resources\ProductLotResource;
use App\Domains\Stock_Management\Models\ProductLot;
use \App\Domains\Stock_Management\Http\Requests\ProductLotRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class ProductLotController
{
    //
    protected ProductLot $product_lot;
    public function __construct(ProductLot $product_lot)
    {
        # code...
        $this->product_lot = $product_lot;

    }
    public function index(Request $request)
    {
        return response()->json(ProductLot::with('warehouse')->get());
    }
    public function pagination(){
        return response()->json($this->product_lot->with('warehouse')->withCount('box')->paginate());
    }
    public function store(ProductLotRequest $request)
    {
        try {
            $lots = $this->product_lot->create($request->validated());
            return response()->json([
                'status' => 'Success!',
                'data' => $lots,
                'message' => "Lot successfully created!"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong'
            ], 500);
        }
    }
    public function update(ProductLotRequest $request, $lot_code)
    {
        try {
            $lots = $this->product_lot->findOrFail($lot_code);
            $lots->update($request->all());
            return response()->json([
                'status' => 'Success!',
                'data' => $lots,
                'message' => "Lot successfully updated!"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
    public function destroy($lot_code)
    {
        try {
            $lot_data = $this->product_lot->findOrFail($lot_code);
            if($lot_data->box->count()>0){
                return response()->json([
                    'status' => 'Error',
                    'messagee' => 'There are items in this lot. Action abort...'
                ]);
            }else{
                $lot_data->delete();
                return response()->json([
                    'status' => 'Success!',
                    'data' => $lot_data,
                    'message' => "Lot successfully deleted!"
                ]);
            }
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
}
