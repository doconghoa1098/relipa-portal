<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use App\Http\Requests\AuthPostRequest;
use App\Http\Requests\AuthPutRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    /**
     * @OA\Post(
     *   path="/api/login",
     *   summary="Login",
     *   operationId="login",
     *   tags={"Auth"},
     *   security={
     *       {"ApiKeyAuth": {}}
     *   },
     *  @OA\Parameter(
     *       name="email",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="anhhn@vnext.vn"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="password",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="123456"
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function login(AuthPostRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {

            return $this->errorResponse(trans('message.unauthorized'),  Response::HTTP_UNAUTHORIZED);
        }

        return $this->createNewToken($token, auth()->user());
    }

    /**
     * Log the member out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Delete(
     *   path="/api/logout",
     *   summary="Logout",
     *   operationId="Logout",
     *   tags={"Auth"},
     *   security={{"bearerAuth": {}}},
     *  
     *   @OA\Parameter(
     *       name="bearer",
     *       in="query",
     *       @OA\Schema(
     *           type="string"
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function logout()
    {
        auth()->logout();

        return $this->successResponse(null, trans('message.signed_out'));
    }

    protected function createNewToken($token, $auth)
    {

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 300,
            'id' => $auth->id,
            'role' => $auth->memberId->role_id,
            'full_name' => $auth->full_name,
            'avatar_official' => $auth->avatar_official,
            'avatar' => $auth->avatar,
            'gender' => $auth->gender,
            'nick_name' => $auth->nick_name,
            'birth_date' => $auth->birth_date,
            'email' => $auth->email,
            'other_email' => $auth->other_email,
            'identity_number' => $auth->identity_number,
            'identity_card_date' => $auth->identity_card_date,
            'identity_card_place' => $auth->identity_card_place,
            'skype' => $auth->skype,
            'facebook' => $auth->facebook,
            'passport_number' => $auth->passport_number,
            'passport_expiration' => $auth->passport_expiration,
            'nationality' => $auth->nationality,
            'bank_name' => $auth->bank_name,
            'bank_account' => $auth->bank_account,
            'marital_status' => $auth->marital_status,
            'academic_level' => $auth->academic_level,
            'permanent_address' => $auth->permanent_address,
            'temporary_address' => $auth->temporary_address,
            'tax_identification' => $auth->tax_identification,
            'healthcare_provider' => $auth->healthcare_provider,
            'emergency_contact_name' => $auth->emergency_contact_name,
            'emergency_contact_relationship' => $auth->emergency_contact_relationship,
            'emergency_contact_number' => $auth->emergency_contact_number,
            'member_code' => $auth->member_code,
            'start_date_official' => $auth->start_date_official,
            'phone' => $auth->phone,
            'created_at' => $auth->created_at,
            'updated_at' => $auth->updated_at,
        ], 'login succes');
    }

    /**
     * @OA\Put(
     *   path="/api/change-pass/{id}",
     *   summary="changePassword",
     *   operationId="changePassword",
     *   tags={"Auth"},
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
     *       name="old_password",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="123456"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="new_password",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="123456"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="new_password_confirmation",
     *       in="query",
     *       @OA\Schema(
     *           type="string",
     *           example="123456"
     *       )
     *   ),
     * 
     *   @OA\Response(response=200, description="Successful operation"),
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function changePassword(AuthPutRequest $request, $memberId)
    {
        $memberId = auth()->user()->id;
        $member = Member::where('id', $memberId)->first();

        if (Hash::check($request->old_password, $member->password)) {
            if (!Hash::check($request->new_password, $member->password)) {
                $member = Member::where('id', $memberId)->update(
                    ['password' => bcrypt($request->new_password)]
                );

                return $this->successResponse(null ,trans('message.change_pass'));
            } else {

                return $this->errorResponse(trans('message.old_pass'), Response::HTTP_BAD_REQUEST);
            }
        } else {

            return $this->errorResponse(trans('message.not_same_pass'), Response::HTTP_BAD_REQUEST);
        }
    }
}
