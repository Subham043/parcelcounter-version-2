<?php

namespace App\Features\ProductImages\DTO;

use App\Features\ProductImages\Requests\ProductImageCreatePostRequest;
use App\Features\ProductImages\Requests\ProductImageUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class ProductImageDTO
{
    public function __construct(
        public readonly ?string $image_title,
        public readonly ?string $image_alt,
        public readonly ?string $image,
    ) {}

    /**
     * @param ProductImageCreatePostRequest|ProductImageUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(ProductImageCreatePostRequest|ProductImageUpdatePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'product-images');
        }
        return new self(
            image_title: $request->validated('image_title') ?? null,
            image_alt: $request->validated('image_alt') ?? null,
            image: $image,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'image_title' => $this->image_title,
            'image_alt' => $this->image_alt,
            'image' => $this->image,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductImageDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
