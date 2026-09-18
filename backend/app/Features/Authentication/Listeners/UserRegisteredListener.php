<?php

namespace App\Features\Authentication\Listeners;

use App\Features\Authentication\Enums\VerifyUserOtpCacheKey;
use App\Features\Authentication\Notifications\RegisterOtpNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Interfaces\OtpServiceInterface;
use Illuminate\Auth\Events\Registered;

class UserRegisteredListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 3;

    /**
     * Create the event listener.
     */
    public function __construct(private OtpServiceInterface $otpService) {}

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $email_otp = $this->otpService->generate(VerifyUserOtpCacheKey::KEY->email_value($event->user->id));
        $phone_otp = $this->otpService->generate(VerifyUserOtpCacheKey::KEY->phone_value($event->user->id));
        $event->user->notify(new RegisterOtpNotification(email_otp: $email_otp, phone_otp: $phone_otp));
    }
}
