<?php

namespace App\Domains\Stock_Management\Http\Controllers;

use App\Domains\Stock_Management\Http\Resources\ProductResource;
use App\Domains\Stock_Management\Models\ProductBox;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Domains\Stock_Management\Models\Product;
use App\Domains\Stock_Management\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductController
{
    //
    protected Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;

    }
    // WORKED!!!
    public function index(Request $request)
    {
        if($request->has('product_code')){
            $products = $this->product->where('product_code', $request->product_code)->get();
        }else{
            $products = $this->product->q($request->get('q'))
                    ->sort($request->get('sort_by'), $request->get('sort_method'))
                    ->dateFrom($request->get('date_from'))
                    ->dateTo($request->get('date_to'))
                    ->paginate();
        }
        return response()->json(ProductResource::collection($products)->response()->getData(true));
    }
    // WORKED!!!
    public function store(ProductRequest $request)
    {
        // validate upcoming product data
        try {
            $data = $request->validated();
            $file = $request->file('image');
            $imageName = time().'.'.$file->extension();
            $imagePath = 'public/files';

            Storage::putFileAs($imagePath, $file, $imageName);
            $file->move($imagePath, $imageName);
            // Storage::putFileAs($imagePath, $imageName);
            $data['image'] = $imageName;
            $product = $this->product->create($data);
            $product->prices()->createMany($request->input('prices', []));
            $product->variant()->createMany($request->input('variants', []));
            return response()->json([
                'status' => 'success',
                // 'data' => $product,
                'data' => $product->load(['prices', 'variants']),
                'message' => "Product successfully created!"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong!'
            ], 500);
        }
    }
    // WORKED!!!!
    public function update(ProductRequest $request, $code){
        try {
            $product = $this->product->findOrFail($code);
            
            $product->update($request->all());
            if($request->hasFile('image')){
                $file = $request->file('image');
                $imageName = time().'.'.$file->extension();
                $imagePath = 'public/files';
                $product['image'] = $imageName;

                Storage::putFileAs($imagePath, $file, $imageName);
                $file->move($imagePath, $imageName);
                $product->save();
                // Storage::putFileAs($imagePath, $imageName);
            }

            $excluded = collect($request->input('prices', []))->filter(function ($item) {
                return !empty($item['id']);
            });
            $product->prices()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('prices', []) as $key => $item) {
                $product->prices()->updateOrCreate(
                    ['id' => data_get($item, 'id')],
                    [
                        'role_id' => $item['role_id'],
                        'value' =>$item['value']],
                );
            } 
            return response()->json([
                'status' => 'Success!',
                'data' => $product->load(['prices', 'variant']),
                'message' => "Product successfully updated!"
            ]);
             // sync requested products
            // sync requested products
            // $excluded = collect($request->input('variants', []))->filter(function ($item) {
            //     return !empty($item['id']);
            // });
            // $product->variant()->whereNotIn('id', $excluded->pluck('id'))->delete();
            // foreach ($request->input('variants', []) as $item) {
            //     $product->variant()->updateOrCreate(
            //         ['id' => data_get($item, 'id')],
            //         [$item]
            //     );
            // }
           
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong!'
            ], 500);
        }
    }
    // WORKED!!!!
    public function destroy($code)
    {
        try {
            $box = ProductBox::where('product_code', $code)->first();
            if ($box) {
                return response([
                    'status' => 'Error!',
                    'message' => 'You cannot remove product because it is used in another field.']
                , 400);
            }else{
                $product = $this->product->findOrFail($code);
                $product->delete();
                return response()->json([
                    'status' => 'Success!',
                    'data' => $product,
                    'message' => "Product successfully deleted!"
                ], 200);
            }
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'Error!',
                'message' => $e->getMessage() ?: 'Something went wrong!'
            ], 500);
        }
    }
}
