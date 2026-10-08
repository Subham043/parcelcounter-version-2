<?php

namespace App\Features\ProductPrices\DTO;

use App\Features\ProductPrices\Requests\ProductPriceFilterRequest;
use Illuminate\Support\Collection;

final class ProductPriceFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
    ) {}

    /**
     * @param ProductPriceFilterRequest $request
     * @return self
     */
    public static function fromRequest(ProductPriceFilterRequest $request): self
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
     * @extends \Illuminate\Support\Collection<int, ProductPriceFilterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
