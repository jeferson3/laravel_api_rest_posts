<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\LoginRequest;
use App\Http\Resources\FailResponseResource;
use App\Http\Resources\SuccessResponseResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt')
            ->only('logout');
    }

    /**
     * @OA\Post (
     *     path="/auth/login",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     @OA\Response(response="400", description="Response with error"),
     *     tags={"Auth"},
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"email", "password"},
     *                  @OA\Property(property="email", type="string" , example="email@email.com"),
     *                  @OA\Property(property="password", type="string" , example="password"),
     *              )
     *          )
     *      )
     *
     *    )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($token = auth()->guard('api')->attempt($request->only('email', 'password'))){
            return response()->json(auth()->user()->responseWithToken($token), 200);
        }
        return (new FailResponseResource(['message' => 'Credenciais inválidas!']))
            ->response()
            ->setStatusCode(401);
    }
    /**
     * @OA\Post (
     *     path="/auth/logout",
     *     summary="PostController",
     *     @OA\Response(response="200", description="Response with success"),
     *     tags={"Auth"},
     *     security={{ "jwt": {} }}
     *    )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return (new SuccessResponseResource(true))
            ->response();
    }

}
