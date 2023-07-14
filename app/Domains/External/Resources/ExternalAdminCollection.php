<?php

namespace App\Domains\External\Resources;

use App\Models\Enumeration\GenderEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalAdminCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'code'          => $this->code ?? null,
            'name_en'       => $this->last_name_en . ' ' . $this->first_name_en ?? null,
            'name_km'       => $this->last_name_km . ' ' . $this->first_name_km ?? null,
            'phone'         => $this->phone_number ?? null,
            'email'         => $this->email ?? null,
            'warehouse_code'         => $this->warehouse_code ?? null,
            'type'         => $this->type,
            'dob'         => $this->dob,
            'gender'        => GenderEnum::ARRAY[$this->gender] ?? [],
            'role'          => RoleExternalAdminCollection::collection($this->whenLoaded('roles')), // $this->roles[0] ?? [],
            'profile_image' => null
        ];
    }
}
