<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterLeaveFormRequest;
use App\Http\Resources\RegisterLeaveResource;
use App\Services\RegisterLeaveService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterLeaveController extends Controller
{
    protected $registerLeaveService;

    public function __construct(RegisterLeaveService $registerLeaveService)
    {
        $this->registerLeaveService = $registerLeaveService;
    }
    /**
     * @OA\post(
     *   path="/api/worksheets/register-leave/create",
     *   summary="Create register leave from worksheet ID",
     *   tags={"Register Leave"},
     *   operationId="createLeave",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="bearer",
     *       in="query",
     *       @OA\Schema(
     *           type="string"
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
    public function createLeave(RegisterLeaveFormRequest $request)
    {
        if ($this->registerLeaveService->checkLeaveQuota($request)) {
            return $this->registerLeaveService->createLeave($request);
        }

        return $this->successResponse("You have run out of requests for the month !");
    }

    /**
     * @OA\put(
     *   path="/api/worksheets/register-leave/update",
     *   summary="Edit register leave from worksheet ID",
     *   tags={"Register Leave"},
     *   operationId="updateLeave",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="bearer",
     *       in="query",
     *       @OA\Schema(
     *           type="string"
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
    public function updateLeave(RegisterLeaveFormRequest $request)
    {
        if ($this->registerLeaveService->checkLeaveQuota($request)) {
            return $this->registerLeaveService->updateLeave($request);
        }

        return $this->successResponse("You have run out of requests for the month !");
    }
}
