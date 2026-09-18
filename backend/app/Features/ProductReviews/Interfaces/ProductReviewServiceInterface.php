<?php

namespace App\Features\ProductReviews\Interfaces;

use App\Features\ProductReviews\DTO\ProductReviewDTO;
use App\Features\ProductReviews\Models\ProductReview;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductReviewServiceInterface
{
    public function paginate(int $product_id, int $total = 10): LengthAwarePaginator;
    public function create(ProductReviewDTO $data, int $product_id): ProductReview;
    public function update(ProductReviewDTO $data, ProductReview $review): ProductReview;
    public function getById(int $product_id, int $id): ProductReview;
    public function delete(ProductReview $review): ProductReview;
    public function toggleActive(ProductReview $review): ProductReview;
}
