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
            'registrationDate' => ( isset($this->created_at) ? $this->created_at : now()  )->format('Y-m-d H:i'),
            'registerForDate' => $this->workDate,
            'checkInWorkSheet' => $this->checkInWorkSheet,
            'checkOutWorkSheet' => $this->checkOutWorkSheet,
            'status' => isset($this->status) ? $this->status : 0,
            'checkin' => isset($this->checkin) ? $this->checkin->format('H:i') : null,
            'checkout' => isset($this->checkout) ? $this->checkout->format('H:i') : null,
            'special_reason' => isset($this->special_reason) ? $this->special_reason : null,
            'reason' => isset($this->reason) ? $this->reason : null,
        ];
    }
}
