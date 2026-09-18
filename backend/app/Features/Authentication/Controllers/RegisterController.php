<?php

namespace App\Features\Authentication\Controllers;

use App\Features\Authentication\DTO\LoginDTO;
use App\Features\Authentication\DTO\RegisterDTO;
use App\Features\Authentication\Interfaces\AuthServiceInterface;
use App\Features\Authentication\Requests\RegisterPostRequest;
use App\Features\Authentication\Resources\AuthCollection;
use App\Features\Users\DTO\UserRoleDTO;
use App\Http\Controllers\Controller;
use App\Http\Enums\Guards;

class RegisterController extends Controller
{
    public function __construct(private AuthServiceInterface $authService) {}

    public function index(RegisterPostRequest $request)
    {
        $user = $this->authService->register(RegisterDTO::fromRequest($request), UserRoleDTO::fromRequest($request));
        $token = $this->authService->login(LoginDTO::fromRequest($request), Guards::API);
        $cookie = $this->authService->set_cookie($token);
        return response()->json([
            'message' => 'Registered successfully.',
            'token_type' => 'Bearer',
            'token' => $token,
            'expires_in' => (int) config('jwt.ttl') * 60,
            'user' => AuthCollection::make($user)
        ], 200)->cookie($cookie);
    }
}
