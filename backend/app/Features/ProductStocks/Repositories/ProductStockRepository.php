<?php

namespace App\Features\ProductStocks\Repositories;


use App\Features\ProductStocks\Models\ProductStock;
use App\Features\ProductStocks\Interfaces\ProductStockRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class ProductStockRepository implements ProductStockRepositoryInterface
{
    public function model(int $product_id): Builder
    {
        return ProductStock::where('product_id', $product_id)->select('id', 'purchase_stock', 'quantity', 'remaining_quantity', 'purchased_at', 'product_id', 'created_at', 'updated_at');
    }

    public function query(int $product_id): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id))
            ->defaultSort('-id')
            ->allowedSorts('id');
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

    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator
    {
        return $this->query($product_id)->paginate($total)->appends(request()->query());
    }

    public function getAll(int $product_id): Collection
    {
        return $this->query($product_id)->lazy(100)->collect();
    }
}
