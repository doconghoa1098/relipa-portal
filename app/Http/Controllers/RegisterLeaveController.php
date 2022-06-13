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
     *       name="request_for_date",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="2022-06-10"
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
     *       name="leave_start",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="10:30"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="leave_end",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="17:30"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="leave_time",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="05:30"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="leave_all_day",
     *       in="query",
     *       @OA\Schema(
     *           type="interger",
     *           example="0"
     *       )
     *   ),
     *   @OA\Parameter(
     *         description="paid",
     *         in="query",
     *         name="request_type",
     *         @OA\Schema(type="radio"),
     *         @OA\Examples(example="int", value="2", summary="paid"),
     *         @OA\Examples(example="uuid", value="3", summary="unpaid"),
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
        return $this->registerLeaveService->createLeave($request);
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
    *    @OA\Parameter(
     *       name="request_for_date",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="2022-06-10"
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
     *       name="leave_start",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="10:30"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="leave_end",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="17:30"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="leave_time",
     *       in="query",
     *       @OA\Schema(
     *           type="time",
     *           example="05:30"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="leave_all_day",
     *       in="query",
     *       @OA\Schema(
     *           type="interger",
     *           example="0"
     *       )
     *   ),
     *   @OA\Parameter(
     *         description="paid",
     *         in="query",
     *         name="request_type",
     *         @OA\Schema(type="radio"),
     *         @OA\Examples(example="int", value="2", summary="paid"),
     *         @OA\Examples(example="uuid", value="3", summary="unpaid"),
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
        return $this->registerLeaveService->updateLeave($request);
    }
}
