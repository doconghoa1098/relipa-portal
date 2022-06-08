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
     * @OA\Get(
     *   path="/api/members/register-leave/{id}",
     *   summary="Viewform to create or update from worksheet ID",
     *   tags={"Register Leave"},
     *   operationId="viewLeave",
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
     *       name="id",
     *       in="path",
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function viewLeave($id)
    {
        $formLeave = new RegisterLeaveResource($this->registerLeaveService->getForm($id));
        if (empty($formLeave->resource)) {
            return $this->errorResponse('Unauthorized!', Response::HTTP_FORBIDDEN);
        };

        return $this->successResponse($formLeave);
    }

    /**
     * @OA\post(
     *   path="/api/members/register-leave/{id}",
     *   summary="Create register leave from worksheet ID",
     *   tags={"Register Leave"},
     *   operationId="createLeave",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
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
    public function createLeave(RegisterLeaveFormRequest $request, $id)
    {
        $registerLeave = $this->registerLeaveService->create($id, $request);

        if ($registerLeave === "403_FORBIDDEN") {
            return $this->errorResponse('Unauthorized!', Response::HTTP_FORBIDDEN);
        };

        if (empty($registerLeave)) {
            return $this->errorResponse('No more request in day', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse($registerLeave, 'Register Leave check-In/check-Out successfully');
    }

    /**
     * @OA\put(
     *   path="/api/members/register-leave/edit/{id}",
     *   summary="Edit register leave from worksheet ID",
     *   tags={"Register Leave"},
     *   operationId="updateLeave",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       @OA\Schema(
     *           type="integer",
     *           example="1"
     *       )
     *   ),
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
    public function updateLeave(RegisterLeaveFormRequest $request, $id)
    {
        $registerLeave = $this->registerLeaveService->updateRegisterLeave($id, $request);

        if ($registerLeave === "403_FORBIDDEN") {
            return $this->errorResponse('Unauthorized!', Response::HTTP_FORBIDDEN);
        };

        if (empty($registerLeave)) {
            return $this->errorResponse('The request cannot be edited once the manager/admin has confirmed/approved ', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse([], 'Update register Leave check-In/check-Out successfully');
    }
}
