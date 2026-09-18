<?php

namespace App\Features\Products\DTO;

use App\Features\Products\Requests\ProductCreatePostRequest;
use App\Features\Products\Requests\ProductUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class ProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $hsn,
        public readonly string $description,
        public readonly string $description_unfiltered,
        public readonly string $brief_description,
        public readonly ?string $image,
        public readonly ?string $meta_title,
        public readonly ?string $meta_description,
        public readonly ?string $meta_keywords,
        public readonly bool $is_active,
        public readonly bool $is_new,
        public readonly bool $is_on_sale,
        public readonly bool $is_featured,
        public readonly int $min_cart_quantity,
        public readonly int $cart_quantity_interval,
        public readonly string $cart_quantity_specification,
    ) {}

    /**
     * @param ProductCreatePostRequest|ProductUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(ProductCreatePostRequest|ProductUpdatePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'products');
        }
        return new self(
            name: $request->validated('name'),
            slug: $request->validated('slug'),
            hsn: $request->validated('hsn') ?? null,
            description: $request->validated('description'),
            description_unfiltered: $request->validated('description_unfiltered'),
            brief_description: $request->validated('brief_description'),
            image: $image,
            meta_title: $request->validated('meta_title') ?? null,
            meta_description: $request->validated('meta_description') ?? null,
            meta_keywords: $request->validated('meta_keywords') ?? null,
            is_active: $request->validated('is_active') ?? true,
            is_new: $request->validated('is_new') ?? false,
            is_on_sale: $request->validated('is_on_sale') ?? false,
            is_featured: $request->validated('is_featured') ?? false,
            min_cart_quantity: $request->validated('min_cart_quantity') ?? 1,
            cart_quantity_interval: $request->validated('cart_quantity_interval') ?? 1,
            cart_quantity_specification: $request->validated('cart_quantity_specification') ?? 'pieces',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'hsn' => $this->hsn,
            'description' => $this->description,
            'description_unfiltered' => $this->description_unfiltered,
            'brief_description' => $this->brief_description,
            'image' => $this->image,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'is_active' => $this->is_active,
            'is_new' => $this->is_new,
            'is_on_sale' => $this->is_on_sale,
            'is_featured' => $this->is_featured,
            'min_cart_quantity' => $this->min_cart_quantity,
            'cart_quantity_interval' => $this->cart_quantity_interval,
            'cart_quantity_specification' => $this->cart_quantity_specification,
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
