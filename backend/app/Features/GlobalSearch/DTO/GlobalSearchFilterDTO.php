<?php

namespace App\Features\GlobalSearch\DTO;

use App\Features\GlobalSearch\Requests\GlobalSearchFilterRequest;
use Illuminate\Support\Collection;

final class GlobalSearchFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
    ) {}

    /**
     * @param GlobalSearchFilterRequest $request
     * @return self
     */
    public static function fromRequest(GlobalSearchFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? 'name',
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
     * @extends \Illuminate\Support\Collection<int, GlobalSearchFilterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
