<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Taxes\Interfaces\TaxRepositoryInterface;
use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Features\Taxes\Repositories\TaxRepository;
use App\Features\Taxes\Services\TaxService;

class TaxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TaxRepositoryInterface::class,
            TaxRepository::class
        );
        $this->app->bind(
            TaxServiceInterface::class,
            TaxService::class
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
