<?php

namespace App\Features\ProductSpecifications\Repositories;


use App\Features\ProductSpecifications\Models\ProductSpecification;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class ProductSpecificationRepository implements ProductSpecificationRepositoryInterface
{
    public function model(int $product_id): Builder
    {
        return ProductSpecification::where('product_id', $product_id)->select('id', 'title', 'description', 'product_id', 'created_at', 'updated_at');
    }

    public function query(int $product_id): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id))
            ->defaultSort('-id')
            ->allowedSorts('id', 'title')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
            ]);
    }

    public function create(array $data, int $product_id): ProductSpecification
    {
        return $this->model($product_id)->create([...$data, 'product_id' => $product_id]);
    }

    public function update(ProductSpecification $specificaton, array $data): ProductSpecification
    {
        $specificaton->update($data);
        return $specificaton->refresh();
    }

    public function delete(ProductSpecification $specificaton): ProductSpecification
    {
        $specificaton->delete();
        return $specificaton;
    }

    public function getById(int $product_id, int $id): ProductSpecification
    {
        return $this->model($product_id)->findOrFail($id);
    }

    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductSpecification
    {
        return $this->model($product_id)->where($column, $value)->first();
    }

    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductSpecification
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
            $q->where('title', $value)
                ->orWhere('description', $value)
                ->orWhereRaw('MATCH(title, description) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
