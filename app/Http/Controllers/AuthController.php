<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use App\Http\Requests\AuthFormRequest;
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
     *   path="/api/auth/login",
     *   summary="Login",
     *   operationId="login",
     *   tags={"Login"},
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
    public function login(AuthFormRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {

            return $this->errorResponse('Unauthorized',  Response::HTTP_UNAUTHORIZED);
        }

        return $this->createNewToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->successResponse(null, ['message' => 'Member successfully signed out']);
    }

    protected function createNewToken($token)
    {

        return $this->successResponse([
            'access_token' => $token,
            'fullname' => auth()->user()->full_name,
        ], 'login succes' ,Response::HTTP_OK);
    }
}
