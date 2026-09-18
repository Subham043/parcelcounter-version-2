<?php

namespace App\Features\ProductColors\Repositories;


use App\Features\ProductColors\Models\ProductColor;
use App\Features\ProductColors\Interfaces\ProductColorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class ProductColorRepository implements ProductColorRepositoryInterface
{
    public function model(int $product_id): Builder
    {
        return ProductColor::where('product_id', $product_id)->select('id', 'name', 'code', 'product_id', 'created_at', 'updated_at');
    }

    public function query(int $product_id): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id))
            ->defaultSort('-id')
            ->allowedSorts('id', 'name')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
            ]);
    }

    public function create(array $data, int $product_id): ProductColor
    {
        return $this->model($product_id)->create([...$data, 'product_id' => $product_id]);
    }

    public function update(ProductColor $color, array $data): ProductColor
    {
        $color->update($data);
        return $color->refresh();
    }

    public function delete(ProductColor $color): ProductColor
    {
        $color->delete();
        return $color;
    }

    public function getById(int $product_id, int $id): ProductColor
    {
        return $this->model($product_id)->findOrFail($id);
    }

    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductColor
    {
        return $this->model($product_id)->where($column, $value)->first();
    }

    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductColor
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
            $q->where('name', $value)
                ->orWhere('code', $value)
                ->orWhereRaw('MATCH(name, code) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
