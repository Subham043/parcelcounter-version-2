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
        public readonly ?int $has_categories,
        public readonly bool $include_category,
        public readonly bool $is_select,
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
            has_categories: $request->validated('filter.has_categories') ?? null,
            include_category: $request->query('include-category') == 'yes',
            is_select: $request->query('is-select') == 'yes',
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
            'has_categories' => $this->has_categories,
            'include_category' => $this->include_category,
            'is_select' => $this->is_select,
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
