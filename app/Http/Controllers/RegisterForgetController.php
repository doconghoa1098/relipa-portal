<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterForgetFormRequest;
use App\Services\RegisterForgetService;
use Illuminate\Http\Response;

class RegisterForgetController extends Controller
{
    protected $registerForgetService;

    public function __construct(RegisterForgetService $registerForgetService)
    {
        $this->registerForgetService = $registerForgetService;
    }

    /**
     * @OA\Post(
     *   path="/api/worksheets/register-forget/create",
     *   summary="Create register forget from worksheet",
     *   tags={"Register Forget"},
     *   operationId="createRegisterForget",
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
     *       name="checkin",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="09:35"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="checkout",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="17:35"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="special_reason",
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *           example="1"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="reason",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Ngày đầu đi làm nên lấy vân tay muộn"
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function createRegisterForget(RegisterForgetFormRequest $request)
    {
        if ($this->registerForgetService->checkRequestQuota($request['request_for_date'])) {
            return $this->registerForgetService->create($request);
        }

        return $this->successResponse("You have run out of requests for the month !");
    }

    /**
     * @OA\Put(
     *   path="/api/worksheets/register-forget/update",
     *   summary="Edit register forget from worksheet",
     *   tags={"Register Forget"},
     *   operationId="updateRegisterForget",
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
     *       name="checkin",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="09:35"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="checkout",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="17:35"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="special_reason",
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *           example="1"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="reason",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Ngày đầu đi làm nên lấy vân tay muộn"
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function updateRegisterForget(RegisterForgetFormRequest $request)
    {
        if ($this->registerForgetService->checkRequestQuota($request['request_for_date'])) {
            return $this->registerForgetService->updateLateEarly($request);
        }

        return $this->successResponse("You have run out of requests for the month !");
    }
}
