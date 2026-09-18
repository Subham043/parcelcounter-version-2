<?php

namespace App\Providers;

use App\Http\Interfaces\OtpServiceInterface;
use App\Http\Services\OtpService;
use Illuminate\Support\ServiceProvider;

class OtpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            OtpServiceInterface::class,
            OtpService::class
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
