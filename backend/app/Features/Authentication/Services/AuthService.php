<?php

namespace App\Features\Authentication\Services;

use App\Features\Authentication\DTO\LoginDTO;
use App\Features\Authentication\DTO\RegisterDTO;
use App\Features\Authentication\Interfaces\AuthServiceInterface;
use App\Features\Users\DTO\UserRoleDTO;
use App\Features\Users\Interfaces\UserRepositoryInterface;
use App\Features\Users\Interfaces\UserServiceInterface;
use App\Features\Users\Models\User;
use App\Http\Enums\Guards;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;

class AuthService implements AuthServiceInterface
{

	public function __construct(private UserRepositoryInterface $userRepository, private UserServiceInterface $userService) {}

	public function register(RegisterDTO $data, UserRoleDTO $role): User
	{
		$user = DB::transaction(function () use ($data, $role) {
			$user = $this->userRepository->create($data->toArray());
			$this->userService->syncRoles($user, [$role]);
			return $user;
		});
		event(new Registered($user));
		return $user->refresh();
	}

	public function login(LoginDTO $credentials, Guards $guard): string|false
	{
		return Auth::guard($guard->value())->attempt($credentials->toArray());
	}

	public function set_cookie(string $token): \Symfony\Component\HttpFoundation\Cookie
	{
		$cookie = cookie(
			config('session.cookie', 'PARCELCOUNTER_AUTH'),
			$token,
			(int) config('session.lifetime'), // minutes
			config('session.path'),
			config('session.domain'),
			app()->environment('production'),  // Secure (only over HTTPS)
			true,  // HttpOnly (not accessible via JS)
			(bool) !config('session.encrypt'),
			'Strict'
		);
		return $cookie;
	}

	public function refresh_token(?Guards $guard = Guards::API): string
	{
		/** @var \Tymon\JWTAuth\JWTGuard $guard */
		$guard = Auth::guard($guard->value());
		return $guard->refresh();
	}

	public function profile(Guards $guard): User
	{
		return AuthCache::getCachedUser($guard);
	}

	public function logout(Guards $guard): void
	{
		AuthCache::forget(Auth::guard($guard->value())->id());
		Auth::guard($guard->value())->logout();
	}
}
