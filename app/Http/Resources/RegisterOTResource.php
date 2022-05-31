<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterOTResource extends JsonResource
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
            'member_id' => $this->member_id,
            'request_type' => $this->request_type,
            'request_for_date' => $this->request_for_date,
            'checkin' => $this->checkin,
            'checkout' => $this->checkout,
            'reason' => $this->reason,

        ];
    }
}
