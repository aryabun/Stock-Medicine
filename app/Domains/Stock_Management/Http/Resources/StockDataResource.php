<?php

namespace App\Domains\Stock_Management\Http\Resources;

use App\Domains\Stock_Management\Models\Product;
use App\Domains\Stock_Management\Models\ProductBox;
use App\Domains\Stock_Management\Models\StockData;
use Illuminate\Http\Resources\Json\JsonResource;

class StockDataResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'product_code' => $this->product_code,
            'current_stock' => $this->current_stock,
            'product' => $this->product,
            'box' => ProductBoxResource::collection($this->box)
        ];
    }
}