<?php

namespace App\Features\PaymentOptions\DTO;

use App\Features\PaymentOptions\Requests\PaymentOptionCreatePostRequest;
use App\Features\PaymentOptions\Requests\PaymentOptionUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class PaymentOptionDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $description,
        public readonly ?string $image,
        public readonly bool $is_active,
    ) {}

    /**
     * @param PaymentOptionCreatePostRequest|PaymentOptionUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(PaymentOptionCreatePostRequest|PaymentOptionUpdatePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'payment-options');
        }
        return new self(
            name: $request->validated('name'),
            slug: $request->validated('slug'),
            description: $request->validated('description') ?? null,
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
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, PaymentOptionDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
