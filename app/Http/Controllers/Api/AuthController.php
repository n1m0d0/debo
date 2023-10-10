<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function logout(): JsonResponse
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json([
            'is_success' => true,
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $executed = RateLimiter::attempt(
            'email' . $request->email,
            $perMinute = 3,
            function () {
            },
            $decayRate = 60,
        );

        if (!$executed) {
            return response()->json([
                'is_success' => false,
                'message' => 'Validation errors',
                'error' => [
                    'limit' => 'Attempts limit exceeded'
                ]
            ], 200);
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $success = $user->createToken('Gungnir')->accessToken;

                return response()->json([
                    'is_success' => true,
                    'data' => [
                        'user_id' => $user->id,
                        'access_token' => $success,
                        'token_type' => 'Bearer'
                    ]
                ], 200);
            } else {
                return response()->json([
                    'is_success' => false,
                    'message' => 'Validation errors',
                    'error' => [
                        'access' => 'Unauthorized'
                    ]
                ], 200);
            }
        }
    }
}
