<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkSheetRequest;
use App\Services\WorkSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkSheetController extends Controller
{
    protected $worksheetService;

    public function __construct(WorkSheetService $worksheetService)
    {
        $this->worksheetService = $worksheetService;
    }

    /**
     * @OA\Get(
     *   path="/api/worksheets",
     *   summary="View worksheet",
     *   tags={"Worksheets"},
     *   operationId="index",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="start_date",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2022-06-01"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="end_date",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2022-06-01"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="work_date",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="asc"
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function index(WorkSheetRequest $request)
    {
        $worksheet = $this->worksheetService->list($request,  Auth::id());

        return $worksheet;
    }

    /**
     * @OA\Get(
     *   path="/api/worksheets/{id}/{type}",
     *   summary="Get Request Forget, Late/early, ...",
     *   tags={"Worksheets"},
     *   operationId="getRequest",
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
     *       name="type",
     *       in="path",
     *       @OA\Schema(
     *           type="integer",
     *           example="1"
     *       )
     *   ),
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function getRequest($id, $type)
    {
        return $this->worksheetService->getRequest($id, $type);
    }
}
