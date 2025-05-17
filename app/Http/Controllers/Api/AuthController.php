<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Generate a token for the authenticated user
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Successfully logged in.',
                'token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        // Revoke the token for the currently authenticated user
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out.'], 200);
    }
}
