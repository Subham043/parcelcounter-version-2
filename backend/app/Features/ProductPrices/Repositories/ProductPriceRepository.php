<?php

namespace App\Features\ProductPrices\Repositories;

use App\Features\ProductPrices\DTO\ProductPriceFilterDTO;
use App\Features\ProductPrices\Models\ProductPrice;
use App\Features\ProductPrices\Interfaces\ProductPriceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class ProductPriceRepository implements ProductPriceRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'price', 'min_quantity', 'product_id', 'created_at', 'updated_at'
        ];
    }

    public function model(int $product_id, ?ProductPriceFilterDTO $dto = null): Builder
    {
        return ProductPrice::where('product_id', $product_id)->select(...$this->getSelectColumns());
    }

    public function query(int $product_id, ?ProductPriceFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id, $dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS);
    }

    public function create(array $data, int $product_id): ProductPrice
    {
        return $this->model($product_id)->create([...$data, 'product_id' => $product_id]);
    }

    public function update(ProductPrice $price, array $data): ProductPrice
    {
        $price->update($data);
        return $price->refresh();
    }

    public function delete(ProductPrice $price): ProductPrice
    {
        $price->delete();
        return $price;
    }

    public function getById(int $product_id, int $id): ProductPrice
    {
        return $this->model($product_id)->findOrFail($id);
    }

    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductPrice
    {
        return $this->model($product_id)->where($column, $value)->first();
    }

    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductPrice
    {
        return $this->model($product_id)->where($column, $value)->firstOrFail();
    }

    public function paginate(int $product_id, ?ProductPriceFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($product_id, $dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(int $product_id, ?ProductPriceFilterDTO $dto = null): Collection
    {
        return $this->query($product_id, $dto)->lazy(100)->collect();
    }
}
