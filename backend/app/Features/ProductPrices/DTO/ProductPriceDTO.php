<?php

namespace App\Features\ProductPrices\DTO;

use App\Features\ProductPrices\Requests\ProductPricePostRequest;
use Illuminate\Support\Collection;

final class ProductPriceDTO
{
    public function __construct(
        public readonly float $price,
        public readonly int $min_quantity,
    ) {}

    /**
     * @param ProductPricePostRequest $request
     * @return self
     */
    public static function fromRequest(ProductPricePostRequest $request): self
    {
        return new self(
            price: $request->validated('price'),
            min_quantity: $request->validated('min_quantity'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'price' => $this->price,
            'min_quantity' => $this->min_quantity,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductPriceDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
