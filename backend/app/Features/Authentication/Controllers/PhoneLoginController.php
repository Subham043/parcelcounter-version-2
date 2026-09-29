<?php

namespace App\Features\Authentication\Controllers;

use App\Features\Authentication\DTO\PhoneLoginDTO;
use App\Features\Authentication\Interfaces\AuthServiceInterface;
use App\Features\Authentication\Requests\PhoneLoginPostRequest;
use App\Features\Authentication\Resources\AuthCollection;
use App\Http\Controllers\Controller;
use App\Http\Enums\Guards;

class PhoneLoginController extends Controller
{
    public function __construct(private AuthServiceInterface $authService) {}

    public function index(PhoneLoginPostRequest $request)
    {

        $token = $this->authService->login(PhoneLoginDTO::fromRequest($request), Guards::API);

        if ($token) {
            $user = $this->authService->profile(Guards::API);
            $cookie = $this->authService->set_cookie($token);
            return response()->json([
                'message' => 'Logged in successfully.',
                'token_type' => 'Bearer',
                'token' => $token,
                'expires_in' => (int) config('jwt.ttl') * 60,
                'user' => AuthCollection::make($user)
            ], 200)->cookie($cookie);
        }
        return response()->json([
            'message' => 'Oops! You have entered invalid credentials',
        ], 400);
    }
}
