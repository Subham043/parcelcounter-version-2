<?php

namespace App\Features\ProductVideos\DTO;

use App\Features\ProductVideos\Requests\ProductVideoPostRequest;
use Illuminate\Support\Collection;

final class ProductVideoDTO
{
    public function __construct(
        public readonly string $video,
    ) {}

    /**
     * @param ProductVideoPostRequest $request
     * @return self
     */
    public static function fromRequest(ProductVideoPostRequest $request): self
    {
        return new self(
            video: $request->validated('video'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'video' => $this->video,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductVideoDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
