<?php

namespace App\Features\Categories\DTO;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

final class CategoryIdDTO
{
    public function __construct(
        public readonly array $category,
    ) {}

    /**
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
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
     * @extends \Illuminate\Support\Collection<int, CategoryIdDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
