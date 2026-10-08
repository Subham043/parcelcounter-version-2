<?php

namespace App\Features\ProductReviews\Repositories;

use App\Features\ProductReviews\DTO\ProductReviewFilterDTO;
use App\Features\ProductReviews\Models\ProductReview;
use App\Features\ProductReviews\Interfaces\ProductReviewRepositoryInterface;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ProductReviewRepository implements ProductReviewRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'rating',
    ];

    private const SEARCH_COLUMNS = [
        'comment',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            ...self::SEARCH_COLUMNS,
            'product_id', 'user_id', 'is_active', 'created_at', 'updated_at'
        ];
    }

    public function model(int $product_id, ?ProductReviewFilterDTO $dto = null): Builder
    {
        return ProductReview::where('product_id', $product_id)->select(...$this->getSelectColumns());
    }

    public function query(int $product_id, ?ProductReviewFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id, $dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
            ]);
    }

    public function create(array $data, int $product_id): ProductReview
    {
        return $this->model($product_id)->create([...$data, 'product_id' => $product_id]);
    }

    public function update(ProductReview $review, array $data): ProductReview
    {
        $review->update($data);
        return $review->refresh();
    }

    public function delete(ProductReview $review): ProductReview
    {
        $review->delete();
        return $review;
    }

    public function getById(int $product_id, int $id): ProductReview
    {
        return $this->model($product_id)->findOrFail($id);
    }

    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductReview
    {
        return $this->model($product_id)->where($column, $value)->first();
    }

    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductReview
    {
        return $this->model($product_id)->where($column, $value)->firstOrFail();
    }

    public function paginate(int $product_id, ?ProductReviewFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($product_id, $dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(int $product_id, ?ProductReviewFilterDTO $dto = null): Collection
    {
        return $this->query($product_id, $dto)->lazy(100)->collect();
    }
}