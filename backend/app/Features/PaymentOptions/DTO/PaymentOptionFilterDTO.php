<?php

namespace App\Features\PaymentOptions\DTO;

use App\Features\PaymentOptions\Requests\PaymentOptionFilterRequest;
use Illuminate\Support\Collection;

final class PaymentOptionFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly bool $is_active,
    ) {}

    /**
     * @param PaymentOptionFilterRequest $request
     * @return self
     */
    public static function fromRequest(PaymentOptionFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            is_active: $request->validated('filter.is_active') == 'yes',
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
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, PaymentOptionDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
