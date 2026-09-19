<?php

namespace App\Features\Products\DTO;

use App\Features\Products\Requests\ProductCreatePostRequest;
use App\Features\Products\Requests\ProductUpdatePostRequest;
use Illuminate\Support\Collection;

final class ProductVideoDTO
{
    public function __construct(
        public readonly ?array $videos,
    ) {}

    /**
     * @param ProductCreatePostRequest|ProductUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(ProductCreatePostRequest|ProductUpdatePostRequest $request): self
    {
        return new self(
            videos: $request->validated('videos') ?? [],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->videos;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
