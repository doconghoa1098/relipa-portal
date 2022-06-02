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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $formForget = new RegisterOTResource($this->registerOTService->getForm($id));

        return $this->successResponse($formForget);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
    // public function update(Request $request, $id)
    // {
    //     $registerOT = $this->registerOTService->update($request, $id);
    // }

    public function update(RegisterOTFormRequest $request, $id)
    {
        $registerOT = $this->registerOTService->update($request, $id);

        if (empty($registerOT)) {
            return $this->errorResponse('The request cannot be edited once the manager/admin has confirmed/approved ', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse([], 'Update register forget check-In/check-Out successfully');
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
