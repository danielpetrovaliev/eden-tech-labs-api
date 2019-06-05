<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken();
            $response = $token->getPayload();

            $author = [
                'name' => $response['name'],
                'email' => $response['email']
            ];

            $request->merge(['author' => $author]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired!'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'You are not authorized!'], 500);
        }

        return $next($request);
    }
}
