<?php

namespace App\Services;

use App\Models\Member;

class MemberService extends BaseService
{
    public function getModel()
    {

        return Member::class;
    }


    public function updateMember($id, $request)
    {

        $members = Member::findOrFail($id);
        if ($request->has('avatar_official')) {
            $image = $request->file('avatar_official')->storeAs(
                'uploads/members',
                uniqid() . $request->avatar_official->getClientOriginalName()
            );
            $avatar = uniqid() . $request->avatar->getClientOriginalName();
        } else {
            $avatar = $members->avatar_official;
        }

        if ($request->has('avatar')) {
            $image = $request->file('avatar')->storeAs(
                'uploads/members',
                uniqid() . $request->avatar->getClientOriginalName()
            );
            $avatar_profile = uniqid() . $request->avatar->getClientOriginalName();
        } else {
            $avatar_profile = $members->avatar;
        }

        $data = [
            'avatar_official' =>  $avatar,
            'avatar' => $avatar_profile,
            'gender' => $request->gender,
            'nick_name' => $request->nick_name,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'identity_number' => $request->identity_number,
            'identity_card_date' => $request->identity_card_date,
            'identity_card_place' => $request->identity_card_place,
            'skype' => $request->skype,
            'facebook' => $request->facebook,
            'passport_number' => $request->passport_number,
            'passport_expiration' => $request->passport_expiration,
            'nationality' => $request->nationality,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'marital_status' => $request->marital_status,
            'academic_level' => $request->academic_level,
            'permanent_address' => $request->permanent_address,
            'temporary_address' => $request->temporary_address,
            'tax_identification' => $request->tax_identification,
            'healthcare_provider' => $request->healthcare_provider,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_relationship' => $request->emergency_contact_relationship,
            'emergency_contact_number' => $request->emergency_contact_number,

        ];

        return  $this->findOrFail($id)->fill($data)->save();
    }
}
