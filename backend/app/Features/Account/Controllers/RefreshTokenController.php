<?php

namespace App\Features\Account\Controllers;

use App\Features\Authentication\Services\AuthService;
use App\Http\Controllers\Controller;

class RefreshTokenController extends Controller
{

    public function __construct(private AuthService $authService){}

    public function index(){

        try {
            //code...
            $token = $this->authService->refresh_token();
            $cookie = $this->authService->set_cookie($token);
    
            return response()->json([
                'message' => 'Token refreshed successfully.',
                'token_type' => 'Bearer',
                'token' => $token,
                'expires_in' =>(int) config('jwt.ttl') * 60,
            ], 200)->cookie($cookie);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => $th->getMessage(),
            ], 401);
        }

    }
}
