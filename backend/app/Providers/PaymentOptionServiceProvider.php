<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\PaymentOptions\Interfaces\PaymentOptionRepositoryInterface;
use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Features\PaymentOptions\Repositories\PaymentOptionRepository;
use App\Features\PaymentOptions\Services\PaymentOptionService;

class PaymentOptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            PaymentOptionRepositoryInterface::class,
            PaymentOptionRepository::class
        );
        $this->app->bind(
            PaymentOptionServiceInterface::class,
            PaymentOptionService::class
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
