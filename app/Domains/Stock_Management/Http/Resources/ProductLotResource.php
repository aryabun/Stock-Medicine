<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\Stock_Management\Http\Resources\ProductBoxResource;

class ProductLotResource extends JsonResource
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
            'id' => $this->id,
            'lot_code'=> $this->lot_code,
            'warehouse_code'=> $this->warehouse_code,
            'box_qty' => $this->box->count(),
            'boxes' => ProductBoxResource::collection($this->box) //Access Box Data Collection
        ];
        // return parent::toArray($request);
    }
}
