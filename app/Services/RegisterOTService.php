<?php

namespace App\Services;

use App\Models\Request;

class RegisterOTService extends BaseService
{
    public function getModel()
    {
        return Request::class;
    }

    public function getRegisterOT()
    {

        return $this->model->latest()->get();
    }
}


