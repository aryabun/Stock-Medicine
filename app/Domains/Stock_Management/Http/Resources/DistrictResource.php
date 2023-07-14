<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
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
            'name_kh' => $this->name_kh,
            'name_en' => $this->name_en,
            'code' => $this->code,
            'gis_code' => $this->gis_code,
            'active' => $this->active,
            'write_uid' => $this->write_uid,
            'commune_qty' => $this->commune->count(),
            'commune' =>CommuneResource::collection($this->commune)
        ];
    }
}
