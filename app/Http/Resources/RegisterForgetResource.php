<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterForgetResource extends JsonResource
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
            'member_id' => $this->member_id,
            'request_type' => $this->request_type,
            'request_for_date' => $this->request_for_date,
            'checkin' => $this->checkin,
            'checkout' => $this->checkout,
            'reason' => $this->reason,
            'status' => $this->status,
            'manager_confirmed_status' => $this->manager_confirmed_status,
            'admin_approved_status' => $this->admin_approved_status,
            'error_count' => $this->error_count,
            'created_at' => $this->created_at,
        ];
    }
}
