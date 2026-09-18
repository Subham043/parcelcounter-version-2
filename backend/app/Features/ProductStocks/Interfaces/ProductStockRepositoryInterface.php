<?php

namespace App\Features\ProductStocks\Interfaces;

use App\Features\ProductStocks\Models\ProductStock;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductStockRepositoryInterface
{
    public function model(int $product_id): Builder;
    public function query(int $product_id): QueryBuilder;
    public function create(array $data, int $product_id): ProductStock;
    public function update(ProductStock $stock, array $data): ProductStock;
    public function delete(ProductStock $stock): ProductStock;
    public function getById(int $product_id, int $id): ProductStock;
    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductStock;
    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductStock;
    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator;
    public function getAll(int $product_id): Collection;
}
