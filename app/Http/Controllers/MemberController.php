<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberFormRequest;
use App\Http\Resources\MemberResource;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::user()->id == $id){

            return new MemberResource($this->memberService->findOrFail($id));
        }

        return $this->errorResponse('Unauthorized!', Response::HTTP_UNAUTHORIZED);
    }

    public function edit($id)
    {
        //
    }


    /**
     * @OA\Put(
     *     path="/api/members/update/{id}",
     *     summary="Updates a member",
     *
     *   @OA\Parameter(
     *       name="avatar",
     *       in="path",
     *       @OA\Schema(
     *           type="file"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="avatar_official",
     *       in="path",
     *       @OA\Schema(
     *           type="file"
     *       )
     *   ),
     *   @OA\Parameter(
     *         description="Gender",
     *         in="path",
     *         name="gender",
     *         @OA\Schema(type="radio"),
     *         @OA\Examples(example="int", value="1", summary="male"),
     *         @OA\Examples(example="uuid", value="2", summary="female"),
     *   ),
     *   @OA\Parameter(
     *       name="nick_name",
     *       in="path",
     *       @OA\Schema(
     *           type="text"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="birth_date",
     *       in="path",
     *       @OA\Schema(
     *           type="date"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="email",
     *       in="path",
     *       @OA\Schema(
     *           type="email"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="identity_number",
     *       in="path",
     *       @OA\Schema(
     *           type="number"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="identity_card_date",
     *       in="path",
     *       @OA\Schema(
     *           type="date"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="identity_card_place",
     *       in="path",
     *       @OA\Schema(
     *           type="date"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="skype",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="facebook",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="passport_number",
     *       in="path",
     *       @OA\Schema(
     *           type="number"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="passport_expiration",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="nationality",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="bank_name",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="bank_account",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     * @OA\Parameter(
     *         description="Gender",
     *         in="path",
     *         name="marital_status",
     *         @OA\Schema(type="radio"),
     *         @OA\Examples(example="int", value="-1", summary="male"),
     *         @OA\Examples(example="uuid", value="1", summary="female"),
     *         @OA\Examples(example="uuid", value="2", summary="female"),
     *         @OA\Examples(example="uuid", value="3", summary="female"),
     *         @OA\Examples(example="uuid", value="4", summary="female"),
     *         @OA\Examples(example="uuid", value="5", summary="female"),
     *   ),
     *   @OA\Parameter(
     *       name="academic_level",
     *       in="path",
     *       @OA\Schema(
     *           type="date"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="permanent_address",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="temporary_address",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="tax_identification",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="healthcare_provider",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="emergency_contact_name",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="emergency_contact_relationship",
     *       in="path",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="emergency_contact_number",
     *       in="path",
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

    public function update(MemberFormRequest $request, $id)
    {
        if(Auth::check()){
            if(Auth::user()->id == $id){
                $this->memberService->updateMember($id, $request);

                return $this->successResponse(null, 'Update member successfully!');
            }
        }

        return $this->errorResponse('Unauthorized!', Response::HTTP_UNAUTHORIZED);
    }

    public function destroy($id)
    {
        //
    }
}
