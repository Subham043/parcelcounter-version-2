<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Testimonials\Interfaces\TestimonialRepositoryInterface;
use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Features\Testimonials\Repositories\TestimonialRepository;
use App\Features\Testimonials\Services\TestimonialService;

class TestimonialServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TestimonialRepositoryInterface::class,
            TestimonialRepository::class
        );
        $this->app->bind(
            TestimonialServiceInterface::class,
            TestimonialService::class
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
