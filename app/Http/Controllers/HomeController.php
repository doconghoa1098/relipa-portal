<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $service;

    public function __construct(HomeService $homeService)
    {
        $this->service = $homeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *   path="/api/home",
     *   summary="Home",
     *   tags={"Home"},
     *   operationId="index",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="sort",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="asc (or desc)"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="perpage",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="10 (20 or 50)"
     *       )
     *   ),
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function index(NotificationRequest $request)
    {
        return $this->service->home($request);
    }

    /**
     * @OA\Get(
     *   path="/api/home/{id}",
     *   summary="Detail notification",
     *   tags={"Home"},
     *   operationId="showNotification",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="id",
     *       description="Notification id",
     *       required=true,
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
    public function showNotification($id)
    {
        return $this->service->showNotice($id);
    }
}
