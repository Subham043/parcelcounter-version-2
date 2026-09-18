<?php

namespace App\Features\Authentication\Services;

use App\Features\Authentication\Enums\AuthCacheKey;
use App\Features\Users\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Http\Enums\Guards;
use Illuminate\Support\Facades\Auth;

class AuthCache
{
    public static function get(int $id)
    {
        $data = Cache::remember(AuthCacheKey::KEY->value($id), now()->addHours(24), function () use ($id) {
            $user = User::select('id', 'name', 'email', 'phone', 'email_verified_at', 'phone_verified_at', 'is_blocked', 'created_at', 'updated_at')->with(['roles' => function ($query) {
                $query->select('id', 'name');
            }])->find($id);

            return serialize($user);
        });

        return unserialize($data);
    }

    public static function forget(int $id)
    {
        Cache::forget(AuthCacheKey::KEY->value($id));
    }

    public static function getCachedUser(?Guards $guard = null)
    {
        $cachedUser = AuthCache::get(Auth::guard($guard->value() ?? Guards::API->value())->id());

        // Override Laravel's auth user
        Auth::guard($guard->value() ?? Guards::API->value())->setUser($cachedUser);

        return $cachedUser;
    }
}
