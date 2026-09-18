<?php

namespace App\Features\Users\DTO;

use App\Features\Users\Requests\UserCreatePostRequest;
use App\Features\Users\Requests\UserUpdatePostRequest;
use App\Features\Authentication\Requests\RegisterPostRequest;
use Illuminate\Support\Collection;

final class UserRoleDTO
{
    public function __construct(
        public readonly string $role,
    ) {}

    /**
     * @param UserCreatePostRequest|UserUpdatePostRequest|RegisterPostRequest $request
     * @return self
     */
    public static function fromRequest(UserCreatePostRequest|UserUpdatePostRequest|RegisterPostRequest $request): self
    {
        return new self(
            role: $request->validated('role'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'role' => $this->role,
        ];
    }

    /**
     * @extends \Illuminate\Support\Collection<int, UserRoleDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
