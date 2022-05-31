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
     *  
     *  @OA\RequestBody( 
     *      required=true,
     *      @OA\JsonContent( 
     *      required={"email","password"}, 
     *      @OA\Property(property="email", type="string", example="anhhn@vnext.vn"), 
     *      @OA\Property(property="password", type="string", example="123456"), 
     *      ), 
     *    ),
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
     * @OA\DELETE(
     *   path="/api/logout",
     *   summary="Logout",
     *   operationId="Logout",
     *   tags={"Auth"},
     *   security={{"bearerAuth": {}}},
     *  
     *  @OA\RequestBody( 
     *      required=true,
     *      @OA\JsonContent( 
     *      required={"bearer"},  
     *      @OA\Property(property="bearer", type="string"),
     *      ), 
     *    ),
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

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

    protected function createNewToken($token, $auth)
    {

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'id' => $auth->id,
            'email' => $auth->email,
            'role' => $auth->memberId->role_id,
        ], 'login succes');
    }

    /**
     * @OA\PUT(
     *   path="/api/change-pass/{id}",
     *   summary="ChangePass",
     *   operationId="ChangePass",
     *   tags={"Auth"},
     *   security={{"bearerAuth": {}}},
     *  
     *  @OA\RequestBody( 
     *      required=true,
     *      @OA\JsonContent( 
     *      required={"id", "bearer", "old_password","new_password", "new_password_confirmation"},  
     *      @OA\Property(property="id", type="string", example="1"), 
     *      @OA\Property(property="bearer", type="string"), 
     *      @OA\Property(property="old_password", type="string", example="123456"), 
     *      @OA\Property(property="new_password", type="string", example="123456"), 
     *      @OA\Property(property="new_password_confirmation"), 
     *      ), 
     *    ),
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
