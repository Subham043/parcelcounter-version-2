<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;

class JwtCookieParser
{
    public function handle(Request $request, Closure $next)
    {
        // Skip CORS preflight requests
        if ($request->isMethod('OPTIONS')) {
            return $next($request);
        }

        // If token is missing in Authorization header, pull from cookie
        $token = $request->bearerToken();
        $cookie_name = config('session.cookie', 'PARCELCOUNTER_AUTH');
        if ((! $token || $token === 'null' || $token === 'undefined') && $request->hasCookie($cookie_name)) {
            $token = $request->cookie($cookie_name);
        }

        if ($token) {
            // Attach header (for guards)
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }
}
