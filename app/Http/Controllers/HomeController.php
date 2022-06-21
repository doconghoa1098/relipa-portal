<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function index(Request $request)
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

    public function downLoad($file)
    {
        $isFile = $this->service->isFileAttachment($file);

        if ($isFile && Storage::exists('public/uploads/notifications/' . $file)) {

            return Storage::download('public/uploads/notifications/' . $file);
        }

        return $this->errorResponse('The file you requested does not exist !', Response::HTTP_NOT_FOUND);
    }

    public function updateNotice($id, Request $request)
    {
        if ($this->service->updateNotification($id, $request)) {

            return $this->successResponse(null, 'Update noti successfully!');
        }

        return $this->errorResponse('Unauthorized !', Response::HTTP_FORBIDDEN);
    }
}
