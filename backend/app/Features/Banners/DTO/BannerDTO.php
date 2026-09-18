<?php

namespace App\Features\Banners\DTO;

use App\Features\Banners\Requests\BannerCreatePostRequest;
use App\Features\Banners\Requests\BannerUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class BannerDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $alt,
        public readonly ?string $desktop_image,
        public readonly ?string $mobile_image,
        public readonly bool $is_active,
    ) {}

    /**
     * @param BannerCreatePostRequest|BannerUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(BannerCreatePostRequest|BannerUpdatePostRequest $request): self
    {
        $desktop_image = null;
        if($request->hasFile('desktop_image')){
            $desktop_image = (new FileStorageService)->uploadPublic($request->file('desktop_image'), 'banners');
        }
        $mobile_image = null;
        if($request->hasFile('mobile_image')){
            $mobile_image = (new FileStorageService)->uploadPublic($request->file('mobile_image'), 'banners');
        }
        return new self(
            title: $request->validated('title') ?? null,
            alt: $request->validated('alt') ?? null,
            desktop_image: $desktop_image,
            mobile_image: $mobile_image,
            is_active: $request->validated('is_active') ?? true,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'title' => $this->title,
            'alt' => $this->alt,
            'desktop_image' => $this->desktop_image,
            'mobile_image' => $this->mobile_image,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, BannerDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
