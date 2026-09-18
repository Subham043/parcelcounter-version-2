<?php

namespace App\Features\ProductPrices\Interfaces;

use App\Features\ProductPrices\Models\ProductPrice;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductPriceRepositoryInterface
{
    public function model(int $product_id): Builder;
    public function query(int $product_id): QueryBuilder;
    public function create(array $data, int $product_id): ProductPrice;
    public function update(ProductPrice $price, array $data): ProductPrice;
    public function delete(ProductPrice $price): ProductPrice;
    public function getById(int $product_id, int $id): ProductPrice;
    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductPrice;
    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductPrice;
    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator;
    public function getAll(int $product_id): Collection;
}
