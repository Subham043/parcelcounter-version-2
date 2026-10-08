<?php

namespace App\Features\ProductSpecifications\Repositories;

use App\Features\ProductSpecifications\DTO\ProductSpecificationFilterDTO;
use App\Features\ProductSpecifications\Models\ProductSpecification;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationRepositoryInterface;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class ProductSpecificationRepository implements ProductSpecificationRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'title',
    ];

    private const SEARCH_COLUMNS = [
        'title',
        'description',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'description', 'product_id', 'created_at', 'updated_at'
        ];
    }

    public function model(int $product_id, ?ProductSpecificationFilterDTO $dto = null): Builder
    {
        return ProductSpecification::where('product_id', $product_id)->select(...$this->getSelectColumns());
    }

    public function query(int $product_id, ?ProductSpecificationFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id, $dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
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

    public function paginate(int $product_id, ?ProductSpecificationFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($product_id, $dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(int $product_id, ?ProductSpecificationFilterDTO $dto = null): Collection
    {
        return $this->query($product_id, $dto)->lazy(100)->collect();
    }
}
