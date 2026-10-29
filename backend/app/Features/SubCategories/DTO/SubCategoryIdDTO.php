<?php

namespace App\Features\SubCategories\DTO;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

final class SubCategoryIdDTO
{
    public function __construct(
        public readonly array $sub_category,
    ) {}

    /**
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
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
     * @extends \Illuminate\Support\Collection<int, SubCategoryIdDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
