<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
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
     *   path="/api",
     *   summary="Home",
     *   tags={"Home"},
     *   operationId="index",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function index(Request $request)
    {
        return NotificationResource::collection($this->service->home($request));
    }
    
}
