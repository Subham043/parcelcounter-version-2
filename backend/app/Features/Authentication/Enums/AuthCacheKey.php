<?php

namespace App\Features\Authentication\Enums;

enum AuthCacheKey: string
{
    case KEY = 'auth';

    public function value(int $id): string
    {
        return $this->value . $id;
    }
}
