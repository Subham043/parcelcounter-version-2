<?php

namespace App\Features\ProductSpecifications\DTO;

use App\Features\ProductSpecifications\Requests\ProductSpecificationPostRequest;
use Illuminate\Support\Collection;

final class ProductSpecificationDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
    ) {}

    /**
     * @param ProductSpecificationPostRequest $request
     * @return self
     */
    public static function fromRequest(ProductSpecificationPostRequest $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductSpecificationDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
