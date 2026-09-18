<?php

namespace App\Providers;

use App\Http\Enums\Throttle;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ThrottleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //global rate limiter for all api requests
        RateLimiter::for(Throttle::API->value(), function (Request $request) {
            $key = $this->throttleKey($request, 'throttle-api');
            return Limit::perMinute(100)->by($key)->response(fn(Request $request, array $headers) => $this->throttleResponse($request, $headers));
        });

        //rate limiter for all api auth requests
        RateLimiter::for(Throttle::AUTH->value(), function (Request $request) {
            $key = $this->throttleKey($request, 'throttle-auth');
            return Limit::perMinute(3)->by($key)->response(fn(Request $request, array $headers) => $this->throttleResponse($request, $headers));
        });
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    private function throttleKey(Request $request, string $for): string
    {
        if (!empty($request->user()->email)) {
            return str()->transliterate(str()->lower($for . ':' . $request->user()->email) . '|' . $request->user()->id . '|' . $request->ip());
        }
        if (!empty($request->email)) {
            return str()->transliterate(
                str()->lower($for . ':' . $request->email) . '|' . $request->ip()
            );
        }
        return str()->transliterate(
            $for . ':' . $request->ip()
        );
    }

    /**
     * Get the rate limiting throttle response for the request.
     */
    private function throttleResponse(Request $request, array $headers)
    {
        $seconds = (int) $headers['Retry-After'] ?? 0;
        $message = 'Too many attempts! You may try again in ';
        if ($seconds > 60) {
            $message .= ceil($seconds / 60) . ' minutes.';
        } else {
            $message .= $seconds . ' seconds.';
        }
        throw new ThrottleRequestsException($message, null, $headers, 429);
    }
}
