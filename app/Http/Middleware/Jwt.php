<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Customer\CustomerUser;
use App\Models\Store\Store;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Jwt
{
    /**
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based Based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="jwt",
     * )
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (TokenInvalidException $exception) {
            return response()->json(['status' => false, 'message' => 'Token inválido!'])->setStatusCode(401);
        } catch (TokenExpiredException $exception) {
            return response()->json(['status' => false, 'message' => 'Token expirado!'])->setStatusCode(401);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => 'Token não encontrado!'])->setStatusCode(401);
        }
    }
}
