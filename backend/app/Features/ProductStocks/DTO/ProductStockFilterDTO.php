<?php

namespace App\Features\ProductStocks\DTO;

use App\Features\ProductStocks\Requests\ProductStockFilterRequest;
use Illuminate\Support\Collection;

final class ProductStockFilterDTO
{
    public function __construct(
        public readonly int $total,
        public readonly string $sort,
    ) {}

    /**
     * @param ProductStockFilterRequest $request
     * @return self
     */
    public static function fromRequest(ProductStockFilterRequest $request): self
    {
        return new self(
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
            'sort' => $this->sort,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductStockFilterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
