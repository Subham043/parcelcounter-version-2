<?php

namespace App\Features\Authentication\Enums;

enum ResetPasswordOtpCacheKey: string
{
    case KEY = 'auth_reset_password_';

    public function value(int $id): string
    {
        return $this->value . $id;
    }
}
