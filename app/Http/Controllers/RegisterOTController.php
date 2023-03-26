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
     * @OA\Post(
     *   path="/api/worksheets/register-ot/create",
     *   summary="Create register overtime",
     *   tags={"Register overtime"},
     *   operationId="createRegisterOT",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="request_ot_time",
     *       in="query",
     *       @OA\Schema(
     *           type="date"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="request_for_date",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2022-06-09"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="checkin",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="06:00"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="checkout",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="17:30"
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
    public function createRegisterOT(RegisterOTFormRequest $request)
    {
        return $this->registerOTService->create($request);
    }

    /**
     * @OA\Put(
     *   path="/api/worksheets/register-ot/update",
     *   summary="Edit register overtime",
     *   tags={"Register overtime"},
     *   operationId="updateRegisterOT",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="request_for_date",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2022-06-09"
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
    public function updateRegisterOT(RegisterOTFormRequest $request)
    {

        return $this->registerOTService->updateOvertime($request);

    }

    public function destroy($id)
    {
        //
    }
}
