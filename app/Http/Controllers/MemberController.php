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
     *   path="/api/members/edit/{id}",
     *   summary="Detail members",
     *   tags={"Members"},
     *   operationId="show",
     *   security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="bearer",
     *       in="query",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
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
        if (Auth::user()->id == $id) {

            $memberInfo =  new MemberResource($this->memberService->findOrFail($id));

            return $this->successResponse($memberInfo);
        }

        return $this->errorResponse('Unauthorized!', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @OA\Put(
     *     path="/api/members/update/{id}",
     *     summary="Updates a member",
     *     tags={"Members"},
     *     operationId="update",
     *     security={{"bearerAuth": {}}},
     *
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="bearer",
     *       in="query",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="avatar",
     *       in="query",
     *       @OA\Schema(
     *           type="file"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="avatar_official",
     *       in="query",
     *       @OA\Schema(
     *           type="file"
     *       )
     *   ),
     *   @OA\Parameter(
     *         description="Gender",
     *         in="query",
     *         name="gender",
     *         @OA\Schema(type="radio"),
     *         @OA\Examples(example="int", value="1", summary="male"),
     *         @OA\Examples(example="uuid", value="2", summary="female"),
     *   ),
     *   @OA\Parameter(
     *       name="nick_name",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="long"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="birth_date",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="1999/02/02"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="other_email",
     *       in="query",
     *       @OA\Schema(
     *           type="email",
     *           example="long@gmail.com"
     *       )
     *   ),
     *    *   @OA\Parameter(
     *       name="identity_number",
     *       in="query",
     *       @OA\Schema(
     *           type="number",
     *           example="1234567899"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="identity_card_date",
     *       in="query",
     *       @OA\Schema(
     *           type="date",
     *           example="2000/12/02"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="identity_card_place",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Việt Nam"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="skype",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="longtt"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="facebook",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Long Bầu"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="passport_number",
     *       in="query",
     *       @OA\Schema(
     *           type="number",
     *           example="213123123123123"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="passport_expiration",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="2022/01/01"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="nationality",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Việt Nam"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="bank_name",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Techcombank"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="bank_account",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="longtt"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="marital_status",
     *       in="query",
     *       @OA\Schema(
     *           type="number",
     *           example="1"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="academic_level",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="12/12"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="permanent_address",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Hạ Bằng - Thạch Thất - Hà Nội"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="temporary_address",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="32/80 - Đỗ Đức Dục - Mễ Trì - Hà Nội"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="tax_identification",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="0123456789"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="healthcare_provider",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Hà Nội"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="emergency_contact_name",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="Phương Anh"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="emergency_contact_relationship",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="0359146002"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="emergency_contact_number",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="0359146004"
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */

    public function update(MemberFormRequest $request, $id)
    {
        if (Auth::check()) {
            if (Auth::user()->id == $id) {
                $this->memberService->updateMember($id, $request);

                return $this->successResponse(null, 'Update member successfully!');
            }
        }

        return $this->errorResponse('Unauthorized!', Response::HTTP_UNAUTHORIZED);
    }
}
