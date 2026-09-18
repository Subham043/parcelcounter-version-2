<?php

namespace App\Features\AboutSections\DTO;

use App\Features\AboutSections\Requests\AboutSectionCreatePostRequest;
use App\Features\AboutSections\Requests\AboutSectionUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class AboutSectionDTO
{
    public function __construct(
        public readonly string $heading,
        public readonly string $description,
        public readonly string $description_unfiltered,
        public readonly ?string $image,
        public readonly bool $is_active,
    ) {}

    /**
     * @param AboutSectionCreatePostRequest|AboutSectionUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(AboutSectionCreatePostRequest|AboutSectionUpdatePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'about-sections');
        }
        return new self(
            heading: $request->validated('heading'),
            description: $request->validated('description'),
            description_unfiltered: $request->validated('description_unfiltered'),
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
            'heading' => $this->heading,
            'description' => $this->description,
            'description_unfiltered' => $this->description_unfiltered,
            'image' => $this->image,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, AboutSectionDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
