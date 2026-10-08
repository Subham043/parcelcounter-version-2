<?php

namespace App\Features\ProductColors\Repositories;

use App\Features\ProductColors\DTO\ProductColorFilterDTO;
use App\Features\ProductColors\Models\ProductColor;
use App\Features\ProductColors\Interfaces\ProductColorRepositoryInterface;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ProductColorRepository implements ProductColorRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'code',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'code', 'product_id', 'created_at', 'updated_at'
        ];
    }

    public function model(int $product_id, ?ProductColorFilterDTO $dto = null): Builder
    {
        return ProductColor::where('product_id', $product_id)->select(...$this->getSelectColumns());
    }

    public function query(int $product_id, ?ProductColorFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id, $dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
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

    public function paginate(int $product_id, ?ProductColorFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($product_id, $dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(int $product_id, ?ProductColorFilterDTO $dto = null): Collection
    {
        return $this->query($product_id, $dto)->lazy(100)->collect();
    }
}
