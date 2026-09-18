<?php

namespace App\Features\Authentication\Notifications;

use App\Http\Channels\Sms\SmsChannel;
use App\Http\Channels\Sms\SmsMessage;
use App\Http\Channels\Sms\SmsTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the notification may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds the notification can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $email_otp, private string $phone_otp)
    {
        $this->afterCommit();
    }

    public function via(object $notifiable): array
    {

        $channels = [SmsChannel::class];

        if (! empty($notifiable->email)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verify your email - ' . config('app.name'))
            ->greeting("Hello {$notifiable->name}!")
            ->line('Please verify your email address to continue using our application.')
            ->line('Your OTP is: ' . $this->email_otp)
            ->line('This OTP will expire in 15 minutes.')
            ->salutation("Team " . config('app.name'));
    }

    /**
     * Get the sms representation of the notification.
     */
    public function toSms(object $notifiable): SmsMessage
    {
        return new SmsMessage(
            templateId: SmsTemplate::LOGIN_OTP,
            phone: $notifiable->phone,
            data: [
                'otp' => $this->phone_otp,
            ]
        );
    }
}
