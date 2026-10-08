<?php

namespace App\Features\Categories\DTO;

use App\Features\Categories\Requests\CategoryFilterRequest;
use Illuminate\Support\Collection;

final class CategoryFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly bool $is_select,
        public readonly bool $is_active,
    ) {}

    /**
     * @param CategoryFilterRequest $request
     * @return self
     */
    public static function fromRequest(CategoryFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            is_select: $request->query('is-select') == 'yes',
            is_active: $request->validated('filter.is_active') == 'yes',
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
            'is_select' => $this->is_select,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, CategoryDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
