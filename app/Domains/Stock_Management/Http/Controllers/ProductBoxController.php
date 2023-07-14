<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Http\Resources\ProductBoxResource;
use App\Domains\Stock_Management\Models\ProductBox;
use \App\Domains\Stock_Management\Http\Requests\ProductBoxRequest;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Throwable;

class ProductBoxController extends Controller
{
    //
    protected ProductBox $product_box;
    public function __construct(ProductBox $product_box)
    {
        # code...
        $this->product_box = $product_box;

    }
    public function index(Request $request)
    {
        if($request->has('product_code')){
            return $this->product_box->where('product_code', $request->product_code)
            ->get();
        }elseif($request->has('box_code')){
            return $this->product_box->where('box_code', $request->box_code)
            ->join('product_lots', 'product_lots.lot_code', '=', 'product_boxes.lot_code')
            ->join('warehouses', 'warehouses.warehouse_code', '=', 'product_lots.warehouse_code')
            ->join('products', 'products.product_code', '=', 'product_boxes.product_code')
            ->get();
        }else{
            return $this->product_box
            ->join('product_lots', 'product_lots.lot_code', '=', 'product_boxes.lot_code')
            ->join('products', 'products.product_code', '=', 'product_boxes.product_code')
            ->join('warehouses', 'warehouses.warehouse_code', 'product_lots.warehouse_code')->paginate();
        }
    }
    public function get_all(){
        return $this->product_box
        ->join('products', 'products.product_code', '=', 'product_boxes.product_code')
        ->join('product_lots', 'product_lots.lot_code', '=', 'product_boxes.lot_code')
        ->join('warehouses', 'warehouses.warehouse_code', 'product_lots.warehouse_code')
        ->where('warehouses.warehouse_code', 'HEADQUARTER')
        ->where('product_boxes.exp_date', '>', Carbon::now() )
        ->get();
    }
    public function store(ProductBoxRequest $request)
    {
        try {
            $box_data = $this->product_box->create($request->validated());
            return response()->json([
                'status' => 'Success!',
                'data' => $box_data,
                'message' => "Box successfully created!"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong!'
            ], 500);
        }
    }
    public function update(ProductBoxRequest $request, $box_code){
        try {
            $box_data = $this->product_box->findOrFail($box_code);
            $box_data->update($request->all());
            return response()->json([
                'status' => 'Success!',
                'data' => $box_data,
                'message' => "Box successfully updated!"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong!'
            ], 500);
        } 
    }
    public function destroy($box_code)
    {
        try {
            $box_data = $this->product_box->findOrFail($box_code);
            $box_data->delete();
            return response()->json([
                'status' => 'Success!',
                'data' => $box_data,
                'message' => "Box successfully deleted!"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
}
