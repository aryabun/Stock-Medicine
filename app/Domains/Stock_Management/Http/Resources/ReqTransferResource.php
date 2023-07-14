<?php

namespace App\Domains\Stock_Management\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReqTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'product_variant';
    public function toArray($request)
    {
        return [
            'request_id'=> $this->request_id,
            'user_id'=> $this->user_id,
            'from_warehouse'=> $this->from_warehouse, //take ID
            'to_warehouse'=> $this->to_warehouse, //Take ID
            'approve_by'=> $this->approve_by,
            'approve_date'=> $this->approve_date,
            'schedule_date'=> $this->schedule_date,
            'eta' => $this->eta,
            'status' => $this->status,
        ];
    }
}
