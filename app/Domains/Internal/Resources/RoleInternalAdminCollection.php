<?php

namespace App\Domains\Internal\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleInternalAdminCollection extends JsonResource
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
            'name' => $this->name,
            'permissions' => $this->permissionCollection($this->permissions)
        ];
    }

    private function permissionCollection($permissions)
    {
        return $permissions->map(function($item){
            return $item->name ?? [];
        });
    }
}
