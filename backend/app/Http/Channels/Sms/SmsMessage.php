<?php

namespace App\Http\Channels\Sms;

class SmsMessage
{
    public function __construct(
        public readonly SmsTemplate $templateId,
        public readonly ?string $phone = null,
        public readonly array $data = [],
    ) {}
}
