<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class MemberResource extends JsonResource
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
            'full_name' => $this->full_name,
            'avatar_official' => URL::to('/storage/uploads/members/'.$this->avatar_official),
            'avatar' => URL::to('/storage/uploads/members/'.$this->avatar),
            'gender' => $this->gender,
            'nick_name' => $this->nick_name,
            'birth_date' => $this->birth_date,
            'email' => $this->email,
            'other_email' => $this->other_email,
            'identity_number' => $this->identity_number,
            'identity_card_date' => $this->identity_card_date,
            'identity_card_place' => $this->identity_card_place,
            'skype' => $this->skype,
            'facebook' => $this->facebook,
            'passport_number' => $this->passport_number,
            'passport_expiration' => $this->passport_expiration,
            'nationality' => $this->nationality,
            'bank_name' => $this->bank_name,
            'bank_account' => $this->bank_account,
            'marital_status' => $this->marital_status,
            'academic_level' => $this->academic_level,
            'permanent_address' => $this->permanent_address,
            'temporary_address' => $this->temporary_address,
            'tax_identification' => $this->tax_identification,
            'healthcare_provider' => $this->healthcare_provider,
            'insurance_number' => $this->insurance_number,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_relationship' => $this->emergency_contact_relationship,
            'emergency_contact_number' => $this->emergency_contact_number,
            'member_code' => $this->member_code,
            'start_date_official' => $this->start_date_official,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
