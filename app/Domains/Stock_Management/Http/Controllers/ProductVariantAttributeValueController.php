<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Http\Resources\ProductVariantAttributeValueResource;
use App\Domains\Stock_Management\Models\ProductVariantAttributeValue;
use Illuminate\Http\Request;

class ProductVariantAttributeValueController
{
    //
    protected ProductVariantAttributeValue $attribute_value;
    public function __construct(ProductVariantAttributeValue $attribute_value)
    {
        # code...
        $this->attribute_value = $attribute_value;

    }
    public function index()
    {
        # code...
        return ProductVariantAttributeValueResource::collection($this->attribute_value->paginate(15));
    }
    public function store(Request $request)
    {
        # code...
        $new_data = $this->attribute_value->create($request->all());
        return new ProductVariantAttributeValueResource($new_data);
    }
    public function update(Request $request, $id)
    {
        # code...
        $record = $this->attribute_value->where('id', $id)->first();

        #if data exist then can be updated
        if($record){
            #update
            #then display new updated data
            $record->update($request->all());
            return response()->json(['message' => 'Updated Successfully!', new ProductVariantAttributeValueResource($record)],200);
        }else{
            #error status 422 if data does not exist
            return response()->json(['error' => "Record not found!"], 422);
        }
    }
    public function destroy($id)
    {
        # code...
        $record = $this->attribute_value->where('id', $id)->first();

        if($record){
            $record->delete();
            return response()->json(["Deleted!"], 200);
        }else{
            return response()->json(["Record not found!"], 422);
            
        }
    }
}
