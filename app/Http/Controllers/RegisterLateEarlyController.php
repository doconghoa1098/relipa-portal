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

    /**
     * @OA\Post(
     *   path="/api/worksheets/register-late-early/create",
     *   summary="Create register late early from worksheet",
     *   tags={"Register Late Early"},
     *   operationId="createRegisterLateEarly",
     *   security={{"bearerAuth": {}}},
     * 
     *   @OA\Parameter(
     *       name="request_for_date",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2022-06-01"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="date_cover_up",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2022/06/12"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="overtime",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="00:16"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="reason",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Em xin làm bù ngày ___ cho thời gian thiếu ngày ___ "
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */

    public function createRegisterLateEarly(RegisterLateEarlyFormRequest $request)
    {
        if ($this->registerLateEarlyService->checkRequestQuota($request['request_for_date'])) {
            return $this->registerLateEarlyService->create($request);
        }

        return $this->successResponse("You have run out of requests for the month !");
    }

    /**
     * @OA\Put(
     *   path="/api/worksheets/register-late-early/update",
     *   summary="Update register late early from worksheet",
     *   tags={"Register Late Early"},
     *   operationId="updateRegisterLateEarly",
     *   security={{"bearerAuth": {}}},
     * 
     *   @OA\Parameter(
     *       name="request_for_date",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2022-06-01",
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="date_cover_up",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2022/06/12"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="overtime",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="00:16"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="reason",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Em xin làm bù ngày"
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function updateRegisterLateEarly(RegisterLateEarlyFormRequest $request)
    {
        if ($this->registerLateEarlyService->checkRequestQuota($request['request_for_date'])) {
            return $this->registerLateEarlyService->updateLateEarly($request);
        }

        return $this->successResponse("You have run out of requests for the month !");
    }
}
