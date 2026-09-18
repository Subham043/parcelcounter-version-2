<?php

namespace App\Features\Users\DTO;

use App\Features\Users\Requests\UserCreatePostRequest;
use Illuminate\Support\Collection;

final class UserCreateDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $email,
        public readonly string $password,
        public readonly string $phone,
        public readonly bool $is_blocked,
    ) {}

    /**
     * @param UserCreatePostRequest $request
     * @return self
     */
    public static function fromRequest(UserCreatePostRequest $request): self
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
            'password' => $this->password,
            'phone' => $this->phone,
            'is_blocked' => $this->is_blocked,
        ];

        if ($this->email) {
            $data['email'] = $this->email;
        }

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, UserCreateDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
