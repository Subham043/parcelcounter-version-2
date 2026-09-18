<?php

namespace App\Features\ProductReviews\DTO;

use App\Features\ProductReviews\Requests\ProductReviewPostRequest;
use Illuminate\Support\Collection;

final class ProductReviewDTO
{
    public function __construct(
        public readonly int $rating,
        public readonly string $comment,
    ) {}

    /**
     * @param ProductReviewPostRequest $request
     * @return self
     */
    public static function fromRequest(ProductReviewPostRequest $request): self
    {
        return new self(
            rating: $request->validated('rating'),
            comment: $request->validated('comment'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'rating' => $this->rating,
            'comment' => $this->comment,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ProductReviewDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
