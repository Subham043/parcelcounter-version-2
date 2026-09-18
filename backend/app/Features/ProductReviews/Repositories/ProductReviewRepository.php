<?php

namespace App\Features\ProductReviews\Repositories;


use App\Features\ProductReviews\Models\ProductReview;
use App\Features\ProductReviews\Interfaces\ProductReviewRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class ProductReviewRepository implements ProductReviewRepositoryInterface
{
    public function model(int $product_id): Builder
    {
        return ProductReview::where('product_id', $product_id)->select('id', 'rating', 'comment', 'product_id', 'user_id', 'is_active', 'created_at', 'updated_at');
    }

    public function query(int $product_id): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id))
            ->defaultSort('-id')
            ->allowedSorts('id', 'rating')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
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

    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator
    {
        return $this->query($product_id)->paginate($total)->appends(request()->query());
    }

    public function getAll(int $product_id): Collection
    {
        return $this->query($product_id)->lazy(100)->collect();
    }
}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->where(function ($q) use ($value) {
            $q->where('comment', $value)
                ->orWhereRaw('MATCH(comment) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
