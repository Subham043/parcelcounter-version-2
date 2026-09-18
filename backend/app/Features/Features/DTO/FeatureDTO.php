<?php

namespace App\Features\Features\DTO;

use App\Features\Features\Requests\FeatureCreatePostRequest;
use App\Features\Features\Requests\FeatureUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class FeatureDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $image,
        public readonly bool $is_active,
    ) {}

    /**
     * @param FeatureCreatePostRequest|FeatureUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(FeatureCreatePostRequest|FeatureUpdatePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'features');
        }
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            image: $image,
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
            'description' => $this->description,
            'image' => $this->image,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, FeatureDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
