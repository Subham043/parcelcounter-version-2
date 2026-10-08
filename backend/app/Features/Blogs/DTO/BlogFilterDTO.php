<?php

namespace App\Features\Blogs\DTO;

use App\Features\Blogs\Requests\BlogFilterRequest;
use Illuminate\Support\Collection;

final class BlogFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly bool $is_active,
        public readonly bool $is_popular,
    ) {}

    /**
     * @param BlogFilterRequest $request
     * @return self
     */
    public static function fromRequest(BlogFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            is_active: $request->validated('filter.is_active') == 'yes',
            is_popular: $request->validated('filter.is_popular') == 'yes',
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
            'is_active' => $this->is_active,
            'is_popular' => $this->is_popular,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, BlogDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
