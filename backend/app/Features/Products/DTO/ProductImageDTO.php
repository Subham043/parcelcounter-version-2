<?php

namespace App\Features\Products\DTO;

use App\Features\Products\Requests\ProductCreatePostRequest;
use App\Features\Products\Requests\ProductUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class ProductImageDTO
{
    public function __construct(
        public readonly ?array $images,
    ) {}

    /**
     * @param ProductCreatePostRequest|ProductUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(ProductCreatePostRequest|ProductUpdatePostRequest $request): self
    {
        $images = [];
        // foreach($request->validated('images') as $image){
        //     if($image->hasFile('image')){
        //         $image = (new FileStorageService)->uploadPublic($image->file('image'), 'product-images');
        //     }
        //     $images[] = $image;
        // }
        foreach ($request->file('images', []) as $image) {
            $images[] = (new FileStorageService)->uploadPublic($image['image'], 'product-images');
        }
        return new self(
            images: $images,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->images;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
