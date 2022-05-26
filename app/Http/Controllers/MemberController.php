<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use App\Services\MemberService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * @OA\Get(
     *   path="/api/members",
     *   summary="Show Members",
     *   operationId="index",
     *   tags={"Members"},
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function index()
    {
        $users = MemberResource::collection($this->memberService->get());

        return $this->successResponse($users);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Get(
     *   path="/api/members/{id}",
     *   summary="Detail members",
     *   tags={"Members"},
     *   operationId="show",
     *   @OA\Parameter(
     *       name="id",
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
    public function show($id)
    {
        
        return new MemberResource($this->memberService->findOrFail($id));
    }

    public function edit($id)
    {
        //
    }

    public function update(MemberRequest $request, $id)
    {
        $this->memberService->updateMember($id, $request);

        return response()->json(['message' => 'Update member successfully!']);
    }

    public function destroy($id)
    {
        //
    }
}
