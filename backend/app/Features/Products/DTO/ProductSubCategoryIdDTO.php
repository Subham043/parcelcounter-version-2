<?php

namespace App\Features\Products\DTO;

use App\Features\Products\Requests\ProductCreatePostRequest;
use App\Features\Products\Requests\ProductUpdatePostRequest;
use Illuminate\Support\Collection;

final class ProductSubCategoryIdDTO
{
    public function __construct(
        public readonly array $sub_category,
    ) {}

    /**
     * @param ProductCreatePostRequest|ProductUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(ProductCreatePostRequest|ProductUpdatePostRequest $request): self
    {
        return new self(
            sub_category: $request->validated('sub_category') ?? [],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->sub_category;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
