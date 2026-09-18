<?php

namespace App\Features\Charges\DTO;

use App\Features\Charges\Requests\ChargeCreatePostRequest;
use App\Features\Charges\Requests\ChargeUpdatePostRequest;
use Illuminate\Support\Collection;

final class ChargeDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly float $value,
        public readonly bool $is_percentage,
        public readonly ?float $include_charges_for_cart_price_below,
        public readonly bool $is_active,
    ) {}

    /**
     * @param ChargeCreatePostRequest|ChargeUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(ChargeCreatePostRequest|ChargeUpdatePostRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            slug: $request->validated('slug'),
            value: $request->validated('value'),
            is_percentage: $request->validated('is_percentage') ?? false,
            include_charges_for_cart_price_below: $request->validated('include_charges_for_cart_price_below') ?? null,
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
            'is_percentage' => $this->is_percentage,
            'include_charges_for_cart_price_below' => $this->include_charges_for_cart_price_below,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ChargeDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
