<?php

namespace App\Http\Enums;

enum Guards:string {
    case WEB = 'web';
    case API = 'api';

    public function value(): string
    {
        return $this->value;
    }

    public function middleware(): string
    {
        return 'auth:'.$this->value;
    }
}
