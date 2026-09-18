<?php

namespace App\Features\Authentication\DTO;

use App\Features\Authentication\Requests\LoginPostRequest;
use App\Features\Authentication\Requests\RegisterPostRequest;
use Illuminate\Support\Collection;

final class LoginDTO
{
    public function __construct(
        public readonly string $phone,
        public readonly string $password,
    ) {}

    /**
     * @param LoginPostRequest $request
     * @return self
     */
    public static function fromRequest(LoginPostRequest|RegisterPostRequest $request): self
    {
        return new self(
            phone: $request->validated('phone'),
            password: $request->validated('password'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'phone' => $this->phone,
            'password' => $this->password,
            'is_blocked' => 0,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, LoginDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
