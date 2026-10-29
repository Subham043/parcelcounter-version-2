<?php

namespace App\Features\Products\DTO;

use App\Features\Products\Requests\ProductFilterRequest;
use Illuminate\Support\Collection;

final class ProductFilterDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $total,
        public readonly string $sort,
        public readonly ?int $category,
        public readonly ?int $sub_category,
        public readonly bool $include_category,
        public readonly bool $include_sub_category,
        public readonly bool $include_tax,
        public readonly bool $include_specification,
        public readonly bool $include_image,
        public readonly bool $include_video,
        public readonly bool $include_color,
        public readonly bool $include_price,
        public readonly bool $include_review,
        public readonly bool $include_stock,
        public readonly bool $include_latest_stock,
        public readonly bool $is_select,
        public readonly bool $is_active,
        public readonly bool $is_new,
        public readonly bool $is_on_sale,
        public readonly bool $is_featured,
    ) {}

    /**
     * @param ProductFilterRequest $request
     * @return self
     */
    public static function fromRequest(ProductFilterRequest $request): self
    {
        return new self(
            search: $request->validated('filter.search') ?? null,
            total: $request->validated('total') ?? 10,
            sort: $request->validated('sort') ?? '-id',
            category: $request->validated('filter.category') ?? null,
            sub_category: $request->validated('filter.sub_category') ?? null,
            include_category: $request->query('include-category') == 'yes',
            include_sub_category: $request->query('include-sub-category') == 'yes',
            include_tax: $request->query('include-tax') == 'yes',
            include_specification: $request->query('include-specification') == 'yes',
            include_image: $request->query('include-image') == 'yes',
            include_video: $request->query('include-video') == 'yes',
            include_color: $request->query('include-color') == 'yes',
            include_price: $request->query('include-price') == 'yes',
            include_review: $request->query('include-review') == 'yes',
            include_stock: $request->query('include-stock') == 'yes',
            include_latest_stock: $request->query('include-latest-stock') == 'yes',
            is_select: $request->query('is-select') == 'yes',
            is_active: $request->validated('filter.is_active') == 'yes',
            is_new: $request->validated('filter.is_new') == 'yes',
            is_on_sale: $request->validated('filter.is_on_sale') == 'yes',
            is_featured: $request->validated('filter.is_featured') == 'yes',
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
            'category' => $this->category,
            'sub_category' => $this->sub_category,
            'include_category' => $this->include_category,
            'include_sub_category' => $this->include_sub_category,
            'include_tax' => $this->include_tax,
            'include_specification' => $this->include_specification,
            'include_image' => $this->include_image,
            'include_video' => $this->include_video,
            'include_color' => $this->include_color,
            'include_price' => $this->include_price,
            'include_review' => $this->include_review,
            'include_stock' => $this->include_stock,
            'include_latest_stock' => $this->include_latest_stock,
            'is_select' => $this->is_select,
            'is_active' => $this->is_active,
            'is_new' => $this->is_new,
            'is_on_sale' => $this->is_on_sale,
            'is_featured' => $this->is_featured,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
