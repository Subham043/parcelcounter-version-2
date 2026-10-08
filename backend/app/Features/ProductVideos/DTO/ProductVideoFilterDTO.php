<?php

namespace App\Features\ProductVideos\DTO;

use App\Features\ProductVideos\Requests\ProductVideoFilterRequest;
use Illuminate\Support\Collection;

final class ProductVideoFilterDTO
{
    public function __construct(
        public readonly int $total,
        public readonly string $sort,
    ) {}

    /**
     * @param ProductVideoFilterRequest $request
     * @return self
     */
    public static function fromRequest(ProductVideoFilterRequest $request): self
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
     * @extends \Illuminate\Support\Collection<int, ProductVideoFilterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
