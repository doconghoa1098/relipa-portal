<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
    * @OA\Get(
    *   path="/api/members",
    *   summary="Show Members",
    *   operationId="index",
    *   tags={"Members"},
    *   security={
    *       {"ApiKeyAuth": {}}
    *   },
    *
    *   @OA\Response(response=200, description="successful operation"),
    *   @OA\Response(response=406, description="not acceptable"),
    *   @OA\Response(response=500, description="internal server error")
    * )
    *
    */
    public function index()
    {
        return MemberResource::collection(Member::all());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
