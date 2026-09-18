<?php

namespace App\Http\Services;

use App\Http\Interfaces\OtpServiceInterface;
use Illuminate\Support\Facades\Cache;

class OtpService implements OtpServiceInterface
{
    private const PREFIX = 'otp:';
    private const TTL = 60 * 15; // 15 minutes

    public function generate(string $identifier): string
    {
        $otp = (string) random_int(100000, 999999);

        Cache::put(
            $this->key($identifier),
            $otp,
            now()->addSeconds(self::TTL)
        );

        return $otp;
    }

    public function verify(string $identifier, string $otp): bool
    {
        $cachedOtp = Cache::get($this->key($identifier));

        if (!$cachedOtp) {
            return false;
        }

        if (! hash_equals($cachedOtp, $otp)) {
            return false;
        }

        Cache::forget($this->key($identifier));

        return true;
    }

    public function reGenerate(string $identifier): string
    {
        Cache::forget($this->key($identifier));

        return $this->generate($identifier);
    }

    public function clear(string $identifier): void
    {
        Cache::forget($this->key($identifier));
    }

    private function key(string $identifier): string
    {
        return self::PREFIX . sha1($identifier);
    }
}
