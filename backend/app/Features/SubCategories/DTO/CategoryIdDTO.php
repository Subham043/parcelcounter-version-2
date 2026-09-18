<?php

namespace App\Features\SubCategories\DTO;

use App\Features\SubCategories\Requests\SubCategoryCreatePostRequest;
use App\Features\SubCategories\Requests\SubCategoryUpdatePostRequest;
use Illuminate\Support\Collection;

final class CategoryIdDTO
{
    public function __construct(
        public readonly array $category,
    ) {}

    /**
     * @param SubCategoryCreatePostRequest|SubCategoryUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(SubCategoryCreatePostRequest|SubCategoryUpdatePostRequest $request): self
    {
        return new self(
            category: $request->validated('category') ?? [],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->category;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, SubCategoryDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
