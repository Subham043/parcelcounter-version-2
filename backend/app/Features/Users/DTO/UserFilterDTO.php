<?php

namespace App\Features\Users\DTO;

use App\Features\Users\Requests\UserFilterRequest;
use Illuminate\Support\Collection;

final class UserFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly ?string $role,
        public readonly bool $is_blocked,
        public readonly bool $is_verified,
    ) {}

    /**
     * @param UserFilterRequest $request
     * @return self
     */
    public static function fromRequest(UserFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            role: $request->validated('filter.role') ?? null,
            is_blocked: $request->validated('filter.is_blocked') == 'yes',
            is_verified: $request->validated('filter.is_verified') == 'yes',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'total' => $this->total,
            'search' => $this->search,
            'sort' => $this->sort,
            'role' => $this->role,
            'is_blocked' => $this->is_blocked,
            'is_verified' => $this->is_verified,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, UserFilterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
