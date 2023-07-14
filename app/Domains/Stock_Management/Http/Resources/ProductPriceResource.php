<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\Stock_Management\Http\Resources\ProductBoxResource;

class ProductPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // public static $wrap = 'lot';
    public function toArray($request)
    {
        return [
            'product_code' => $this->product_code,
            'value' => $this->value,
            'role_id' => $this->role_id,
            'role' => $this->role,
        ];
        // return parent::toArray($request);
    }
}
