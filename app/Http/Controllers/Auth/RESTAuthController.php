<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class RESTAuthController extends Controller {

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['status' => 'error', 'message' => 'Unable to create token.'], 500);
        }


        return response()->json([
            'status' => 'success',
            'data' => ['token' => $token, 'user' => Auth::user()->toArray()]
        ], 200);
    }
}