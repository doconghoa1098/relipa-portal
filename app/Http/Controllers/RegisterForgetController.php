<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterForgetFormRequest;
use App\Http\Resources\RegisterForgetResource;
use App\Services\RegisterForgetService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterForgetController extends Controller
{
    protected $registerForgetService;

    public function __construct(RegisterForgetService $registerForgetService)
    {
        $this->registerForgetService = $registerForgetService;
    }

    /**
     * @OA\Get(
     *   path="/api/members/register-forget/{id}",
     *   summary="Viewform to create or update from worksheet ID",
     *   tags={"Register Forget"},
     *   operationId="viewForget",
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
     *       in="query",
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
    public function viewForget($id)
    {
        $formForget = new RegisterForgetResource($this->registerForgetService->getForm($id));

        return $this->successResponse($formForget);
    }

    /**
     * @OA\post(
     *   path="/api/members/register-forget/{id}",
     *   summary="Create register forget from worksheet ID",
     *   tags={"Register Forget"},
     *   operationId="createForget",
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
     *       in="query",
     *       @OA\Schema(
     *           type="integer"
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
    public function createForget(RegisterForgetFormRequest $request, $id)
    {
        $registerForget = $this->registerForgetService->create($id, $request);

        if (empty($registerForget)) {
            return $this->errorResponse('No more request in day', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse($registerForget, 'Register forget check-In/check-Out successfully');
    }

    /**
     * @OA\put(
     *   path="/api/members/register-forget/edit/{id}",
     *   summary="Edit register forget from request ID",
     *   tags={"Register Forget"},
     *   operationId="updateForget",
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
     *       in="query",
     *       @OA\Schema(
     *           type="integer",
     *           example="1"
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
    public function updateForget(RegisterForgetFormRequest $request, $id)
    {
        $registerForget = $this->registerForgetService->updateRegisterForget($id, $request);

        if (empty($registerForget)) {
            return $this->errorResponse('The request cannot be edited once the manager/admin has confirmed/approved ', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse([], 'Update register forget check-In/check-Out successfully');
    }
}
