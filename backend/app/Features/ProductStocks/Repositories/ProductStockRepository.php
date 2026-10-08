<?php

namespace App\Features\ProductStocks\Repositories;

use App\Features\ProductStocks\DTO\ProductStockFilterDTO;
use App\Features\ProductStocks\Models\ProductStock;
use App\Features\ProductStocks\Interfaces\ProductStockRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class ProductStockRepository implements ProductStockRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'purchase_stock', 'quantity', 'remaining_quantity', 'purchased_at', 'product_id', 'created_at', 'updated_at'
        ];
    }
    public function model(int $product_id, ?ProductStockFilterDTO $dto = null): Builder
    {
        return ProductStock::where('product_id', $product_id)->select(...$this->getSelectColumns());
    }

    public function query(int $product_id, ?ProductStockFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id, $dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS);
    }

    public function create(array $data, int $product_id): ProductStock
    {
        return $this->model($product_id)->create([...$data, 'remaining_quantity' => $data['quantity'], 'product_id' => $product_id]);
    }

    public function update(ProductStock $stock, array $data): ProductStock
    {
        if($data['quantity'] != $stock->quantity) {
            $data['remaining_quantity'] = $data['quantity'];
        }
        $stock->update($data);
        return $stock->refresh();
    }

    public function delete(ProductStock $stock): ProductStock
    {
        $stock->delete();
        return $stock;
    }

    public function getById(int $product_id, int $id): ProductStock
    {
        return $this->model($product_id)->findOrFail($id);
    }

    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductStock
    {
        return $this->model($product_id)->where($column, $value)->first();
    }

    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductStock
    {
        return $this->model($product_id)->where($column, $value)->firstOrFail();
    }

    public function paginate(int $product_id, ?ProductStockFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($product_id, $dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(int $product_id, ?ProductStockFilterDTO $dto = null): Collection
    {
        return $this->query($product_id, $dto)->lazy(100)->collect();
    }
}
