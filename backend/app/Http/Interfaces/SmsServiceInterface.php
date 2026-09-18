<?php

namespace App\Http\Interfaces;

interface SmsServiceInterface
{
    public function send(string $phone, string $templateId, array $data = []): bool;
}
