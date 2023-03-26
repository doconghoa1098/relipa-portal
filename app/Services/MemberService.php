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
        $members = $this->findOrFail($id);
        $members->fill($request->all());
        $members->avatar_official = $this->upload($members, 'avatar_official', $request);
        $members->avatar = $this->upload($members, 'avatar', $request);

        return  $members->save();
    }
}
