<?php

namespace App\Services;

use App\Models\Request;

class RegisterOTService extends BaseService
{
    public function getModel()
    {
        return Request::class;
    }

}
