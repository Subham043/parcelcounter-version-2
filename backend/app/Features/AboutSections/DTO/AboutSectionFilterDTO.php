<?php

namespace App\Features\AboutSections\DTO;

use App\Features\AboutSections\Requests\AboutSectionFilterRequest;
use Illuminate\Support\Collection;

final class AboutSectionFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly bool $is_active,
    ) {}

    /**
     * @param AboutSectionFilterRequest $request
     * @return self
     */
    public static function fromRequest(AboutSectionFilterRequest $request): self
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
     * @extends \Illuminate\Support\Collection<int, AboutSectionFilterDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
