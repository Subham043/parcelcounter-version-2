<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\BillingInformations\Interfaces\BillingInformationRepositoryInterface;
use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Features\BillingInformations\Repositories\BillingInformationRepository;
use App\Features\BillingInformations\Services\BillingInformationService;

class BillingInformationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            BillingInformationRepositoryInterface::class,
            BillingInformationRepository::class
        );
        $this->app->bind(
            BillingInformationServiceInterface::class,
            BillingInformationService::class
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
