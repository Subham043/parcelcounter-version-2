<?php

namespace App\Features\ProductStocks\DTO;

use App\Features\ProductStocks\Requests\ProductStockPostRequest;
use Illuminate\Support\Collection;

final class ProductStockDTO
{
    public function __construct(
        public readonly float $purchase_stock,
        public readonly int $quantity,
        public readonly string $purchased_at,
    ) {}

    /**
     * @param ProductStockPostRequest $request
     * @return self
     */
    public static function fromRequest(ProductStockPostRequest $request): self
    {
        return new self(
            purchase_stock: $request->validated('purchase_stock'),
            quantity: $request->validated('quantity'),
            purchased_at: $request->validated('purchased_at'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'purchase_stock' => $this->purchase_stock,
            'quantity' => $this->quantity,
            'purchased_at' => $this->purchased_at,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductStockDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
