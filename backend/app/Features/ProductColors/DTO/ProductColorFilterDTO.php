<?php

namespace App\Features\ProductColors\DTO;

use App\Features\ProductColors\Requests\ProductColorFilterRequest;
use Illuminate\Support\Collection;

final class ProductColorFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
    ) {}

    /**
     * @param ProductColorFilterRequest $request
     * @return self
     */
    public static function fromRequest(ProductColorFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
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
     * @extends \Illuminate\Support\Collection<int, ProductColorFilterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
