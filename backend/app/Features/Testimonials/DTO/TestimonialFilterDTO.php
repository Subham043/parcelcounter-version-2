<?php

namespace App\Features\Testimonials\DTO;

use App\Features\Testimonials\Requests\TestimonialFilterRequest;
use Illuminate\Support\Collection;

final class TestimonialFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly bool $is_active,
    ) {}

    /**
     * @param TestimonialFilterRequest $request
     * @return self
     */
    public static function fromRequest(TestimonialFilterRequest $request): self
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
     * @extends \Illuminate\Support\Collection<int, TestimonialDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
