<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductBoxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'boxes';
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'box_code' => $this->box_code,
            'product_code' => $this->product_code,
            'lot_code' => $this->lot_code,
            'bottle_qty' => $this->bottle_qty,
            'bottle_unit' => $this->product[0]->unit,
            'qty_per_bottle' => $this->qty_per_bottle,
            'status' => $this->status,
            'exp_date'  => Carbon::parse($this->exp_date)->toFormattedDateString(), 
            'products' => $this->product, #Product Collections
        ];
    }
}
