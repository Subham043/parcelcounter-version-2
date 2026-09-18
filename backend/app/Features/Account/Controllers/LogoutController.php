<?php

namespace App\Features\Account\Controllers;

use App\Features\Authentication\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Enums\Guards;

class LogoutController extends Controller
{
    
    public function __construct(private AuthService $authService)
    {}

    public function index(){

        $this->authService->logout(Guards::API);
        return response()->json([
            'message' => 'Logged out successfully.',
        ], 200)->withoutCookie(config('session.cookie'));
    }
}
