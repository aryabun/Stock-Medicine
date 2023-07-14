<?php

namespace App\Domains\Stock_Management\Http\Controllers;


use App\Domains\Stock_Management\Http\Requests\ProductVariantRequest;
use App\Domains\Stock_Management\Http\Resources\ProductVariantResource;
use App\Domains\Stock_Management\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController
{
    //
    protected ProductVariant $product_variant;
    public function __construct(ProductVariant $product_variant)
    {
        # code...
        $this->product_variant = $product_variant;

    }
    public function index()
    {
        # code...
        // if(Prod)
        return $this->product_variant
        ->select(['products.product_name', 'products.product_code', 'product_variant_attribute.attribute', 'product_variant_attribute_value.value'])
        ->join('products', 'products.product_code', '=', 'product_variants.product_code')
        ->join('product_variant_attribute','product_variant_attribute.id', '=', 'product_variants.attribute_id')
        ->join('product_variant_attribute_value','product_variant_attribute_value.id', '=', 'product_variants.value_id')
        ->get();
    }
    public function store(ProductVariantRequest $request)
    {
        # code...
        $variant = $request->all();
        // if faced some error during validation, it's because of custom request rule
        foreach($variant as $variants){
            
            return new ProductVariantResource($this->product_variant->create([
                'product_code' => $variants['product_code'],
                'attribute_id' => $variants['attribute_id'],
                'value_id' => $variants['value_id']
            ]));
        }
    }
    public function update(Request $request, $id)
    {
        # code...
        $record = $this->product_variant->where('id', $id)->first();

        #if data exist then can be updated
        if($record){
            #update
            #then display new updated data
            $record->update($request->all());
            return response()->json(['message' => 'Updated Successfully!', new ProductVariantResource($record)],200);
        }else{
            #error status 422 if data does not exist
            return response()->json(['error' => "Record not found!"], 422);
        }
    }
    public function destroy($id)
    {
        # code...
        $record = $this->product_variant->where('id', $id)->first();

        if($record){
            $record->delete();
            return response()->json(["Deleted!"], 200);
        }else{
            return response()->json(["Record not found!"], 422);
            
        }
    }
}
