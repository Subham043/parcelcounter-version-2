<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Certifications\Interfaces\CertificationRepositoryInterface;
use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Features\Certifications\Repositories\CertificationRepository;
use App\Features\Certifications\Services\CertificationService;

class CertificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CertificationRepositoryInterface::class,
            CertificationRepository::class
        );
        $this->app->bind(
            CertificationServiceInterface::class,
            CertificationService::class
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
