<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Closure;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (! $request->expectsJson()) {
            return response()->json([
                'message' => 'Accept Only Json',
            ], 400);
        }

        try {
            $authenticated = app(JWTAuth::class)->parseToken()->getPayload()->get('user')->id;

            if (!$authenticated) {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Unauthorized'
                ], 401);
            }
        }  catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status_code' => 401,
                'messages' => 'token_expired'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status_code' => 401,
                'messages' => 'token_invalid'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status_code' => 401,
                'messages' => 'token_absent'
            ], 401);
        }

        return $next($request);
    }
}
