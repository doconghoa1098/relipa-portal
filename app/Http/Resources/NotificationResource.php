<?php

namespace App\Http\Resources;

use App\Models\Notification;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'subject' => $this->subject,
            'created_by' => Notification::find($this->id)->authorInfo->full_name,
            'published_to' => $this->published_to,
            'published_date' => $this->published_date->format('d-m-Y'),
            'attachment' => $this->attachment,
        ];
    }
}