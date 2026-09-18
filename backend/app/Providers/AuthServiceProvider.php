<?php

namespace App\Providers;

use App\Features\Authentication\Interfaces\AuthServiceInterface;
use App\Features\Authentication\Listeners\UserRegisteredListener;
use App\Features\Authentication\Services\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //event listeners
        Event::listen(
            Registered::class,
            UserRegisteredListener::class,
        );
    }
}
