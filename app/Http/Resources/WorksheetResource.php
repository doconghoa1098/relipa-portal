<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorksheetResource extends JsonResource
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
            'id' => $this->id,
            'member_id' => $this->member_id,
            'work_date' => $this->work_date,
            'checkin' => $this->checkin,
            'checkin_original' => $this->checkin_original,
            'checkout' => $this->checkout,
            'checkout_original' => $this->checkout_original,
            'late' => $this->late,
            'early' => $this->early,
            'in_office' => $this->in_office,
            'ot_time' => $this->ot_time,
            'work_time' => $this->work_time,
            'lack' => $this->lack,
            'compensation' => $this->compensation,
            'paid_leave' => $this->paid_leave,
            'unpaid_leave' => $this->unpaid_leave,
            'note' => $this->note,
        ];
    }
}
