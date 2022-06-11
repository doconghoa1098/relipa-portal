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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(WorkSheetRequest $request)
    {
        $worksheet = $this->worksheetService->list($request,  Auth::id());

        return $worksheet;
        // return $this->successResponse($worksheet);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRequest($id, $type)
    {
        //
    }


}
