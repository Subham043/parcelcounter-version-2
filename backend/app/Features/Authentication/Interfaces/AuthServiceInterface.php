<?php

namespace App\Features\Authentication\Interfaces;

use App\Features\Authentication\DTO\LoginDTO;
use App\Features\Authentication\DTO\RegisterDTO;
use App\Features\Users\DTO\UserRoleDTO;
use App\Features\Users\Models\User;
use App\Http\Enums\Guards;

interface AuthServiceInterface
{
    public function register(RegisterDTO $data, UserRoleDTO $role): User;
    public function login(LoginDTO $credentials, Guards $guard): string|false;
    public function set_cookie(string $token): \Symfony\Component\HttpFoundation\Cookie;
    public function refresh_token(?Guards $guard = Guards::API): string;
    public function profile(Guards $guard): User;
    public function logout(Guards $guard): void;
}
