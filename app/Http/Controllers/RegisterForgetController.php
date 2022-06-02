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
        $formForget = new RegisterForgetResource($this->registerForgetService->getForm($id));

        return $this->successResponse($formForget);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterForgetFormRequest $request)
    {
        $registerForget = $this->registerForgetService->create($request);

        if (empty($registerForget)) {
            return $this->errorResponse('No more request in day', Response::HTTP_BAD_REQUEST);
        };

        return $this->successResponse($registerForget, 'Register forget check-In/check-Out successfully');
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
    public function update(RegisterForgetFormRequest $request, $id)
    {
        $registerForget = $this->registerForgetService->updateRegisterForget($id, $request);

        if (empty($registerForget)) {
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
