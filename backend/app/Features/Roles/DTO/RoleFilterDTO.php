<?php

namespace App\Features\Roles\DTO;

use App\Features\Roles\Requests\RoleFilterRequest;
use Illuminate\Support\Collection;

final class RoleFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
    ) {}

    /**
     * @param RoleFilterRequest $request
     * @return self
     */
    public static function fromRequest(RoleFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? 'name',
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
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, RoleDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
