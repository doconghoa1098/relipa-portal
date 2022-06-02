<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterOTFormRequest;
use App\Http\Resources\RegisterOTResource;
use App\Services\RegisterOTService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisterOTController extends Controller
{

    protected $registerOTService;

    public function __construct(RegisterOTService $registerOTService)
    {
        $this->registerOTService = $registerOTService;
    }
    /**
     * @OA\Get(
     *   path="/api/register-ot/{id}",
     *   summary="Detail register overtime",
     *   tags={"Register overtime"},
     *   operationId="create",
     *   security={{"bearerAuth": {}}},
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
    public function create($id)
    {
        $formForget = new RegisterOTResource($this->registerOTService->getForm($id));

        return $this->successResponse($formForget);
    }
    /**
     * @OA\post(
     *   path="/api/register-ot/1",
     *   summary="Create register overtime",
     *   tags={"Register overtime"},
     *   operationId="store",
     *   security={{"bearerAuth": {}}},
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
     *           type="date"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="checkin",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="08:35"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="checkout",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="17:35"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="request_ot_time",
     *       in="query",
     *       @OA\Schema(
     *           type="date"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="reason",
     *       in="query",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function store(Request $request, $id)
    {
        $registerOT = $this->registerOTService->create($request, $id);

        if (empty($registerOT))
        {
            return $this->errorResponse('No more requests in day!', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse($registerOT, 'Register overtime successfully');
    }

    /**
     * @OA\put(
     *   path="/api/register-ot/edit/1",
     *   summary="Edit register overtime",
     *   tags={"Register overtime"},
     *   operationId="updateRegisterOT",
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
     *       name="request_ot_time",
     *       in="query",
     *       @OA\Schema(
     *           type="date"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="reason",
     *       in="query",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function updateRegisterOT(RegisterOTFormRequest $request, $id)
    {
        $registerOT = $this->registerOTService->update($request, $id);

        if (empty($registerOT)) {
            return $this->errorResponse('The request cannot be edited once the manager/admin has confirmed/approved ', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse([], 'Update register forget check-In/check-Out successfully');
    }

    public function destroy($id)
    {
        //
    }
}
