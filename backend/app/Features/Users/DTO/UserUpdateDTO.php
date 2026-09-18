<?php

namespace App\Features\Users\DTO;

use App\Features\Users\Requests\UserUpdatePostRequest;
use Illuminate\Support\Collection;

final class UserUpdateDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $email,
        public readonly ?string $password,
        public readonly string $phone,
        public readonly bool $is_blocked,
    ) {}

    /**
     * @param UserUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(UserUpdatePostRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email') ?? null,
            password: $request->validated('password'),
            phone: $request->validated('phone'),
            is_blocked: $request->validated('is_blocked') ?? false,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'is_blocked' => $this->is_blocked,
        ];

        if ($this->email) {
            $data['email'] = $this->email;
        }

        if ($this->password) {
            $data['password'] = $this->password;
        }

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, UserUpdateDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
