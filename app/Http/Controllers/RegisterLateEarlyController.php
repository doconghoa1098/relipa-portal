<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterLateEarlyFormRequest;
use App\Services\RegisterLateEarlyService;
use Illuminate\Http\Response;

class RegisterLateEarlyController extends Controller
{
    protected $registerLateEarlyService;

    public function __construct(RegisterLateEarlyService $registerLateEarlyService)
    {
        $this->registerLateEarlyService = $registerLateEarlyService;
    }

    public function createRegisterLateEarly(RegisterLateEarlyFormRequest $request)
    {
        if ($this->registerLateEarlyService->checkRequestQuota($request['request_for_date'])) {
            return $this->registerLateEarlyService->create($request);
        }

        return $this->successResponse("You have run out of requests for the month !");
    }

    public function updateRegisterLateEarly(RegisterLateEarlyFormRequest $request)
    {
        if ($this->registerLateEarlyService->checkRequestQuota($request['request_for_date'])) {
            return $this->registerLateEarlyService->updateLateEarly($request);
        }

        return $this->successResponse("You have run out of requests for the month !");
    }
}
