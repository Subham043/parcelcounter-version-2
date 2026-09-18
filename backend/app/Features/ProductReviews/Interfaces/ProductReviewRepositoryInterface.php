<?php

namespace App\Features\ProductReviews\Interfaces;

use App\Features\ProductReviews\Models\ProductReview;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductReviewRepositoryInterface
{
    public function model(int $product_id): Builder;
    public function query(int $product_id): QueryBuilder;
    public function create(array $data, int $product_id): ProductReview;
    public function update(ProductReview $review, array $data): ProductReview;
    public function delete(ProductReview $review): ProductReview;
    public function getById(int $product_id, int $id): ProductReview;
    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductReview;
    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductReview;
    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator;
    public function getAll(int $product_id): Collection;
}
