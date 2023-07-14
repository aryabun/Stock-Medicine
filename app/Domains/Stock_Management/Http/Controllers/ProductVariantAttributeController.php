<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Http\Resources\ProductVariantAttributeResource;
use App\Domains\Stock_Management\Models\ProductVariantAttribute;
use Request;

class ProductVariantAttributeController
{

    protected ProductVariantAttribute $attribute;
    public function __construct(ProductVariantAttribute $attribute)
    {
        # code...
        $this->attribute = $attribute;

    }
    public function index()
    {
        //
        return ProductVariantAttributeResource::collection($this->attribute->get());
    }

    
    public function store(Request $request)
    {
        //
        $new_data = $this->attribute->create($request->all());
        return new ProductVariantAttributeResource($new_data);
    }

    public function update(Request $request, $id)
    {
        //
        $record = $this->attribute->where('id', $id)->first();

        #if data exist then can be updated
        if($record){
            #update
            #then display new updated data
            $record->update($request->all());
            return response()->json(['message' => 'Updated Successfully!', new ProductVariantAttributeResource($record)],200);
        }else{
            #error status 422 if data does not exist
            return response()->json(['error' => "Record not found!"], 422);
        }
    }


    public function destroy($id)
    {
        //
        $record = $this->attribute->where('id', $id)->first();

        if($record){
            $record->delete();
            return response()->json(["Deleted!"], 200);
        }else{
            return response()->json(["Record not found!"], 422);
            
        }
    }
}
