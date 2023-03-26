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
            'registrationDate' => ( isset($this->created_at) ? $this->created_at : now()  )->format('Y-m-d H:i'),
            'registerForDate' => $this->workDate,
            'checkinWorkSheet' => $this->checkinWorkSheet,
            'checkoutWorkSheet' => $this->checkoutWorkSheet,
            'status' => isset($this->status) ? $this->status : 0,
            'reason' => isset($this->reason) ? $this->reason : null,
            'actual_overtime' => isset($this->actual_OT) ? $this->actual_OT : null,
        ];
    }
}
