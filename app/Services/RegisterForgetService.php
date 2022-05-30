<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Request;

class RegisterForgetService extends BaseService
{
    public function getModel()
    {
        return Request::class;
    } 
}
