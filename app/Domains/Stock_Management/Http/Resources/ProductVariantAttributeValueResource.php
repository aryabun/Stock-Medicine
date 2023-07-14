<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantAttributeValueResource extends JsonResource
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
            
            'id' => $this->id,
            'attribute_id' => $this->attribute,
            // 'attribute_id' => ProductVariantAttributeValueResource::collection($this->attribute),
            'value' => $this->value,
            'status' => $this->status,
        ];
    }
}
