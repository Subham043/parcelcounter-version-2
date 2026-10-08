<?php

namespace App\Features\Charges\DTO;

use App\Features\Charges\Requests\ChargeFilterRequest;
use Illuminate\Support\Collection;

final class ChargeFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly bool $is_active,
        public readonly bool $is_percentage,
    ) {}

    /**
     * @param ChargeFilterRequest $request
     * @return self
     */
    public static function fromRequest(ChargeFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            is_active: $request->validated('filter.is_active') == 'yes',
            is_percentage: $request->validated('filter.is_percentage') == 'yes',
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
            'is_percentage' => $this->is_percentage,
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
