<?php

namespace App\Features\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class AdminVerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public bool $createdByAdmin,
        public ?string $plainPassword = null
    ) {}

    public function via($notifiable): array
    {
        return ['mail']; // REQUIRED
    }

    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        $mail = (new MailMessage)
            ->subject('Verify Email Address')
            ->greeting('Hello ' . $notifiable->name);

        if ($this->createdByAdmin) {
            $mail->line('Your account was created by an administrator. The credentials are as follows: ');
            $mail->line('Email: ' . $notifiable->email);
            $mail->line('Password: ' . $this->plainPassword);
        }

        return $mail
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $url)
            ->line('If you did not create an account, no action is required.');
    }
}
