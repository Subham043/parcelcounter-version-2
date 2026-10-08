<?php

namespace App\Features\ProductImages\DTO;

use App\Features\ProductImages\Requests\ProductImageFilterRequest;
use Illuminate\Support\Collection;

final class ProductImageFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
    ) {}

    /**
     * @param ProductImageFilterRequest $request
     * @return self
     */
    public static function fromRequest(ProductImageFilterRequest $request): self
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
     * @extends \Illuminate\Support\Collection<int, ProductImageFilterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
