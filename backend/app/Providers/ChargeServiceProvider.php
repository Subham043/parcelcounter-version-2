<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Charges\Interfaces\ChargeRepositoryInterface;
use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Features\Charges\Repositories\ChargeRepository;
use App\Features\Charges\Services\ChargeService;

class ChargeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ChargeRepositoryInterface::class,
            ChargeRepository::class
        );
        $this->app->bind(
            ChargeServiceInterface::class,
            ChargeService::class
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
