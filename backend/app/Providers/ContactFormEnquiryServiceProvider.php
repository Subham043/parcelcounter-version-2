<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryRepositoryInterface;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryServiceInterface;
use App\Features\ContactFormEnquiries\Repositories\ContactFormEnquiryRepository;
use App\Features\ContactFormEnquiries\Services\ContactFormEnquiryService;

class ContactFormEnquiryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ContactFormEnquiryRepositoryInterface::class,
            ContactFormEnquiryRepository::class
        );
        $this->app->bind(
            ContactFormEnquiryServiceInterface::class,
            ContactFormEnquiryService::class
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
