<?php

namespace App\Features\SubCategories\DTO;

use App\Features\SubCategories\Requests\SubCategoryFilterRequest;
use Illuminate\Support\Collection;

final class SubCategoryFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly ?int $category,
        public readonly bool $include_category,
        public readonly bool $is_select,
        public readonly bool $is_active,
    ) {}

    /**
     * @param SubCategoryFilterRequest $request
     * @return self
     */
    public static function fromRequest(SubCategoryFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            category: $request->validated('filter.category') ?? null,
            include_category: $request->query('include-category') == 'yes',
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
            'category' => $this->category,
            'include_category' => $this->include_category,
            'is_select' => $this->is_select,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, SubCategoryDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
