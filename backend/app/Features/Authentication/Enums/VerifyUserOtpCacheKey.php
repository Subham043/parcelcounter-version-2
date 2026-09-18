<?php

namespace App\Features\Authentication\Enums;

enum VerifyUserOtpCacheKey: string
{
    case KEY = 'auth_verification_';

    public function email_value(int $id): string
    {
        return $this->value. 'email_' . $id;
    }
    
    public function phone_value(int $id): string
    {
        return $this->value. 'phone_' . $id;
    }
}
