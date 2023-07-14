<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Http\Resources\WarehouseResource;
use App\Domains\Stock_Management\Models\Warehouse;
use App\Domains\Stock_Management\Models\WarehouseOwner;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class WarehouseController
{

    //
    protected Warehouse $warehouse;
    public function __construct(Warehouse $warehouse)
    {
        # code...
        // $this->middleware('api:internalAdmin');
        $this->warehouse = $warehouse;
    }
    // WORKED!!!
    public function index(Request $request)
    {
        # code...
        if($request->has('warehouse_code')){
            return $this->warehouse->where('warehouse_code', $request->warehouse_code)->get();
        }else{
            $warehouse_data = $this->warehouse->q($request->get('q'))
                    ->sort($request->get('sort_by'), $request->get('sort_method'))
                    ->dateFrom($request->get('date_from'))
                    ->dateTo($request->get('date_to'))
                    ->paginate();
            return response()->json(WarehouseResource::collection($warehouse_data)->response()->getData(true)); 
        }
        // return response()->json($this->warehouse->get());
    }
    // WORKED!!!
    public function store(Request $request)
    {
        # code...
        #Get all input and Validate
        $validate = $request->validate([
            'warehouse_code' => '',
            'hospital_id' => '',
            'level' => '',
            'village_id' => '',
            'address' => '',
            'warehouse_name' => '',
            'province_id' => "required|integer",
            'district_id' => "required|integer",
            'commune_id' => "required|integer"
        ]);
        try {
            $prefix = "WH-";
            $length = strlen($prefix) + 4;
            $validate['warehouse_code'] = IdGenerator::generate(['table' => 'warehouses','field' =>'warehouse_code', 'length' => $length, 'prefix' => $prefix]);
            // if($request->warehouse_name == ''){
            //     $validate['warehouse_name'] = $this->warehouse->warehouse_code;
            // }else{$validate['warehouse_name']= $request->warehouse_name;}
            $warehouse_data = $this->warehouse->create($validate);
            $data = [];
            for($i=0; $i<=4; $i++){
                $data[$i] = ['warehouse_code'=>$warehouse_data->warehouse_code]; 
                // array_push($data, $i);
            }
            $warehouse_data->lots()->createMany($data);
            return response()->json([
                'status' => 'Success!',
                'data' => $warehouse_data->load(['lots']),
                'message' => "Warehouse successfully created!"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong!'
            ], 500);
        }
    }
    // WORKED!!!!
    public function update(Request $request, $warehouse_code){
        $validate = $request->validate([
            'province_id' => "required|integer",
            'district_id' => "required|integer",
            'commune_id' => "required|integer"
        ]);
        try {
            $warehouse_data = $this->warehouse->findOrFail($warehouse_code);
            $warehouse_data->update($validate);
            return response()->json([
                'status' => 'Success!',
                'data' => $warehouse_data,
                'message' => "Warehouse successfully updated!"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong!'
            ], 500);
        } 
    }
    // WORKED!!!!
    public function destroy($warehouse_code)
    {
        try {
            $warehouse_data = $this->warehouse->findOrFail($warehouse_code);
            $warehouse_data->delete();
            return response()->json([
                'status' => 'Success!',
                'data' => $warehouse_data,
                'message' => "Warehouse successfully deleted!"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
}
