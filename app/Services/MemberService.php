<?php

namespace App\Services;

use App\Models\Member;

class MemberService extends BaseService
{
    public function getModel()
    {
        return Member::class;
    }
}
