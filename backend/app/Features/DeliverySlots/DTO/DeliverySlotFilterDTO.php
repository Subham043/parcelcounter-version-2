<?php

namespace App\Features\DeliverySlots\DTO;

use App\Features\DeliverySlots\Requests\DeliverySlotFilterRequest;
use Illuminate\Support\Collection;

final class DeliverySlotFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly bool $is_active,
        public readonly bool $is_cod_allowed,
    ) {}

    /**
     * @param DeliverySlotFilterRequest $request
     * @return self
     */
    public static function fromRequest(DeliverySlotFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            is_active: $request->validated('filter.is_active') == 'yes',
            is_cod_allowed: $request->validated('filter.is_cod_allowed') == 'yes',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'total' => $this->total,
            'search' => $this->search,
            'sort' => $this->sort,
            'is_active' => $this->is_active,
            'is_cod_allowed' => $this->is_cod_allowed,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, DeliverySlotDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
