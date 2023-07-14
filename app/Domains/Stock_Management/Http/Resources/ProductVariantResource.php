<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'attribute' => $this->attribute->pluck('attribute'), 
            // 'attribute' => ProductVariantAttributeResource::collection($this->attribute) , 
            'value' => $this->value->pluck('value'),
            // 'value_id' => $this->value_id, 
        ];
    }
}
