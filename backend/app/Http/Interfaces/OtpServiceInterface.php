<?php

namespace App\Http\Interfaces;

interface OtpServiceInterface
{
    public function generate(string $identifier): string;
    public function verify(string $identifier, string $otp): bool;
    public function reGenerate(string $identifier): string;
    public function clear(string $identifier): void;
}
