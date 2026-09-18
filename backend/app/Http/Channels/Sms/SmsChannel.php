<?php

namespace App\Http\Channels\Sms;

use App\Http\Interfaces\SmsServiceInterface;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function __construct(
        protected SmsServiceInterface $smsService
    ) {}

    public function send(object $notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toSms')) {
            return;
        }

        $sms = $notification->toSms($notifiable);

        $phone = $sms->phone
            ?? $notifiable->routeNotificationFor('sms')
            ?? $notifiable->phone;

        $this->smsService->send(
            phone: $phone,
            templateId: $sms->templateId->value,
            data: $sms->data,
        );
    }
}
