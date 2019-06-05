<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthorizationController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $credentials = $request->only('name', 'email');

        try {
            $factory = JWTFactory::customClaims(array_merge([
                'sub'   => 'user info',
            ], $credentials));

            $payload = $factory->make();

            $token = JWTAuth::encode($payload);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create a token!'], 500);
        }

        return response()->json(['token' => $token])->header('Authorization','Bearer '.$token);
    }

    public function whoAmI(Request $request)
    {
        try {
            $token = JWTAuth::parseToken();
            $response = $token->getPayload();
        } catch (JWTException $e) {
            return response()->json(['error' => 'You are not authorized!'], 500);
        }

        return $response;
    }
}
