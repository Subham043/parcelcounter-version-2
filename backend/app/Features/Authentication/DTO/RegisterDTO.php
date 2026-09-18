<?php

namespace App\Features\Authentication\DTO;

use App\Features\Authentication\Requests\RegisterPostRequest;
use Illuminate\Support\Collection;

final class RegisterDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $email,
        public readonly string $password,
        public readonly string $phone,
    ) {}

    /**
     * @param RegisterPostRequest $request
     * @return self
     */
    public static function fromRequest(RegisterPostRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            password: $request->validated('password'),
            email: $request->validated('email') ?? null,
            phone: $request->validated('phone'),
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
        ];

        if ($this->email) {
            $data['email'] = $this->email;
        }

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, RegisterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
