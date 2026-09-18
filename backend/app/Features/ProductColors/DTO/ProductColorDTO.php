<?php

namespace App\Features\ProductColors\DTO;

use App\Features\ProductColors\Requests\ProductColorPostRequest;
use Illuminate\Support\Collection;

final class ProductColorDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $code,
    ) {}

    /**
     * @param ProductColorPostRequest $request
     * @return self
     */
    public static function fromRequest(ProductColorPostRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            code: $request->validated('code'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'code' => $this->code,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductColorDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
