<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\FailResponseResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
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
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        return response()->json(\request()->all());
        if (auth()->guard('api')->attempt(\request(['email', 'password']))){
            return response()->json(auth()->user()->responseWithToken(), 200);
        }
        return (new FailResponseResource(false))
            ->response([], 401);
    }

}
