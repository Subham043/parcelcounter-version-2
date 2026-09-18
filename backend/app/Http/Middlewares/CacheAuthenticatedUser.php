<?php

namespace App\Http\Middlewares;

use App\Features\Authentication\Services\AuthCache;
use App\Http\Enums\Guards;
use Illuminate\Support\Facades\Auth;
use Closure;

class CacheAuthenticatedUser
{
    public function handle($request, Closure $next)
    {
        if (($request->bearerToken() || $request->hasCookie(config('session.cookie'))) && Auth::guard(Guards::API->value())->check()) {
            $user = AuthCache::getCachedUser(Guards::API);
            if ($user?->is_blocked==true) {
                abort(403, 'Your account has been blocked. Please contact the administrator.');
            }
        }

        return $next($request);
    }
}
