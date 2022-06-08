<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\AuthPostRequest;
use App\Http\Requests\AuthPutRequest;
use App\Http\Resources\MemberResource;
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
            'email' => $auth->email,
            'full_name' => $auth->full_name,
            'role' => $auth->memberId->role_id,
        ], 'login succes');
    }

    /**
     * @OA\Put(
     *   path="/api/change-pass",
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
    public function changePassword(AuthPutRequest $request)
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
