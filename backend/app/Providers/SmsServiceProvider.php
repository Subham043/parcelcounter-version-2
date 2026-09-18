<?php

namespace App\Providers;

use App\Http\Interfaces\SmsServiceInterface;
use App\Http\Services\SmsService;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            SmsServiceInterface::class,
            SmsService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
