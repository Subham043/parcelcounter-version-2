<?php

namespace App\Features\Authentication\DTO;

use App\Features\Authentication\Requests\EmailLoginPostRequest;
use Illuminate\Support\Collection;

final class EmailLoginDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    /**
     * @param EmailLoginPostRequest $request
     * @return self
     */
    public static function fromRequest(EmailLoginPostRequest $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'is_blocked' => 0,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, EmailLoginDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
