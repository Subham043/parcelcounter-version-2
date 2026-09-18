<?php

namespace App\Features\Testimonials\DTO;

use App\Features\Testimonials\Requests\TestimonialCreatePostRequest;
use App\Features\Testimonials\Requests\TestimonialUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class TestimonialDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $designation,
        public readonly int $star,
        public readonly string $message,
        public readonly ?string $image,
        public readonly bool $is_active,
    ) {}

    /**
     * @param TestimonialCreatePostRequest|TestimonialUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(TestimonialCreatePostRequest|TestimonialUpdatePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'testimonials');
        }
        return new self(
            name: $request->validated('name'),
            designation: $request->validated('designation'),
            star: $request->validated('star'),
            message: $request->validated('message'),
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
            'name' => $this->name,
            'designation' => $this->designation,
            'star' => $this->star,
            'message' => $this->message,
            'image' => $this->image,
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
