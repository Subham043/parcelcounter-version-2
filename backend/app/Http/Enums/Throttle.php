<?php

namespace App\Http\Enums;

enum Throttle:string {
    case AUTH = 'auth';
    case API = 'api';

    public function value(): string
    {
        return $this->value;
    }

    public function middleware(): string
    {
        return 'throttle:'.$this->value;
    }
}
