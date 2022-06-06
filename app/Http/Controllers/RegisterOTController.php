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
     *   operationId="viewRegisterOT",
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
    public function viewRegisterOT($id)
    {

        $formOT = new RegisterOTResource($this->registerOTService->getForm($id));
        if (empty($formOT->resource)) {
            return $this->errorResponse('Unauthorized!', Response::HTTP_FORBIDDEN);
        };

        return $this->successResponse($formOT);
    }
    /**
     * @OA\Post(
     *   path="/api/register-ot/{id}",
     *   summary="Create register overtime",
     *   tags={"Register overtime"},
     *   operationId="createRegisterOT", 
     *   security={{"bearerAuth": {}}},
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
    public function createRegisterOT(RegisterOTFormRequest $request, $id)
    {
        $registerOT = $this->registerOTService->create($request, $id);

        if ($registerOT === "403_FORBIDDEN") {
            return $this->errorResponse('Unauthorized!', Response::HTTP_FORBIDDEN);
        };

        if ($registerOT === "validator"){
            return $this->errorResponse('Your overtime is more than actual overtime!', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (empty($registerOT)) {
            return $this->errorResponse('No more request in day', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse($registerOT, 'Register overtime successfully');
    }

    /**
     * @OA\Put(
     *   path="/api/register-ot/edit/{id}",
     *   summary="Edit register overtime",
     *   tags={"Register overtime"},
     *   operationId="updateRegisterOT",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
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

        if ($registerOT === "403_FORBIDDEN") {
            return $this->errorResponse('Unauthorized!', Response::HTTP_FORBIDDEN);
        };

        if ($registerOT === "validator"){
            return $this->errorResponse('Your overtime is more than actual overtime!', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (empty($registerOT)) {
            return $this->errorResponse('The request cannot be edited once the manager/admin has confirmed/approved ', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse([], 'Update register overtime successfully');

    }

    public function destroy($id)
    {
        //
    }
}
