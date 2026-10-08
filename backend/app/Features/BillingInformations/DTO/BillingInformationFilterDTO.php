<?php

namespace App\Features\BillingInformations\DTO;

use App\Features\BillingInformations\Requests\BillingInformationFilterRequest;
use Illuminate\Support\Collection;

final class BillingInformationFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
    ) {}

    /**
     * @param BillingInformationFilterRequest $request
     * @return self
     */
    public static function fromRequest(BillingInformationFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
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
            'search' => $this->search,
            'sort' => $this->sort,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, BillingInformationDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
