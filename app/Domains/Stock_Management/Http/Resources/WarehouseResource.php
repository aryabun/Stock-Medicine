<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'warehouse_code' => $this->warehouse_code,
            'warehouse_name' => $this->warehouse_name,
            'hospital_id' => $this->hospital_id,
            'province' => $this->province,
            'district' => $this->district,
            'commune' => $this->commune,
            'village' => $this->village,
            'address' => $this->address,
            'lots_count' => count($this->lots),
            'lot' => $this->lots,
        ];
    }
}