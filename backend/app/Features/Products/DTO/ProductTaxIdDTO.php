<?php

namespace App\Features\Products\DTO;

use App\Features\Products\Requests\ProductCreatePostRequest;
use App\Features\Products\Requests\ProductUpdatePostRequest;
use Illuminate\Support\Collection;

final class ProductTaxIdDTO
{
    public function __construct(
        public readonly array $tax,
    ) {}

    /**
     * @param ProductCreatePostRequest|ProductUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(ProductCreatePostRequest|ProductUpdatePostRequest $request): self
    {
        return new self(
            tax: $request->validated('tax') ?? [],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->tax;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
