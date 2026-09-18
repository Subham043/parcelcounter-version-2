<?php

namespace App\Features\Categories\DTO;

use App\Features\Categories\Requests\CategoryCreatePostRequest;
use App\Features\Categories\Requests\CategoryUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class CategoryDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $heading,
        public readonly string $description,
        public readonly string $description_unfiltered,
        public readonly ?string $image,
        public readonly ?string $meta_title,
        public readonly ?string $meta_description,
        public readonly ?string $meta_keywords,
        public readonly bool $is_active,
    ) {}

    /**
     * @param CategoryCreatePostRequest|CategoryUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(CategoryCreatePostRequest|CategoryUpdatePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'categories');
        }
        return new self(
            name: $request->validated('name'),
            slug: $request->validated('slug'),
            heading: $request->validated('heading') ?? null,
            description: $request->validated('description'),
            description_unfiltered: $request->validated('description_unfiltered'),
            image: $image,
            meta_title: $request->validated('meta_title') ?? null,
            meta_description: $request->validated('meta_description') ?? null,
            meta_keywords: $request->validated('meta_keywords') ?? null,
            is_active: $request->validated('is_active') ?? true,
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
            'heading' => $this->heading,
            'description' => $this->description,
            'description_unfiltered' => $this->description_unfiltered,
            'image' => $this->image,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, CategoryDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
