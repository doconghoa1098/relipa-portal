<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Services\HomeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

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
     *   @OA\Parameter(
     *       name="bearer",
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
    public function index(Request $request)
    {
        return NotificationResource::collection($this->service->home($request));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
