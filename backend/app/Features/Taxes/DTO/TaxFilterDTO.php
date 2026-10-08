<?php

namespace App\Features\Taxes\DTO;

use App\Features\Taxes\Requests\TaxFilterRequest;
use Illuminate\Support\Collection;

final class TaxFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly bool $is_active,
        public readonly bool $is_inter_state_tax,
    ) {}

    /**
     * @param TaxFilterRequest $request
     * @return self
     */
    public static function fromRequest(TaxFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            is_active: $request->validated('filter.is_active') == 'yes',
            is_inter_state_tax: $request->validated('filter.is_inter_state_tax') == 'yes',
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
            'is_inter_state_tax' => $this->is_inter_state_tax,
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
