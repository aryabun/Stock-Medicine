<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'products';
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_code' => $this->product_code,
            'product_name' => $this->product_name,
            'unit' => $this->unit,
            'stock' => $this->stock()->pluck('current_stock'),
            'med_type' => $this->med_type,
            'disease_type' => $this->disease_type,
            'strength' => $this->strength,
            'status' => $this->status,
            'description' => $this->description,
            'image' => asset('storage/files/' . $this->image),
            'image_name' => $this->image,
            'prices' => ProductPriceResource::collection($this->prices),
            'variant' => ProductVariantResource::collection($this->variant),
        ];
    }
}
 