<?php

namespace App\Features\DeliverySlots\DTO;

use App\Features\DeliverySlots\Requests\DeliverySlotPostRequest;
use Illuminate\Support\Collection;

final class DeliverySlotDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $start_time,
        public readonly string $end_time,
        public readonly bool $is_cod_allowed,
        public readonly bool $is_active,
    ) {}

    /**
     * @param DeliverySlotPostRequest $request
     * @return self
     */
    public static function fromRequest(DeliverySlotPostRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            start_time: $request->validated('start_time'),
            end_time: $request->validated('end_time'),
            is_cod_allowed: $request->validated('is_cod_allowed') ?? false,
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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_cod_allowed' => $this->is_cod_allowed,
            'is_active' => $this->is_active,
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
