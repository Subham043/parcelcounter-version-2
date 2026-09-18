<?php

namespace App\Features\Taxes\DTO;

use App\Features\Taxes\Requests\TaxCreatePostRequest;
use App\Features\Taxes\Requests\TaxUpdatePostRequest;
use Illuminate\Support\Collection;

final class TaxDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly float $value,
        public readonly bool $is_inter_state_tax,
        public readonly bool $is_active,
    ) {}

    /**
     * @param TaxCreatePostRequest|TaxUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(TaxCreatePostRequest|TaxUpdatePostRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            slug: $request->validated('slug'),
            value: $request->validated('value'),
            is_inter_state_tax: $request->validated('is_inter_state_tax') ?? false,
            is_active: $request->validated('is_active') ?? true,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'value' => $this->value,
            'is_inter_state_tax' => $this->is_inter_state_tax,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, TaxDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
