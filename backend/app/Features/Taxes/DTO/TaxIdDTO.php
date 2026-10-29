<?php

namespace App\Features\Taxes\DTO;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

final class TaxIdDTO
{
    public function __construct(
        public readonly array $tax,
    ) {}

    /**
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
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
     * @extends \Illuminate\Support\Collection<int, TaxIdDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
