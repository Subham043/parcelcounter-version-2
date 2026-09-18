<?php

namespace App\Features\Products\Interfaces;

use App\Features\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductRepositoryInterface
{
    public function model(bool $withCategory = false): Builder;
    public function query(bool $withCategory = false): QueryBuilder;
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function syncCategories(Product $product, array $data): Product;
    public function delete(Product $product): Product;
    public function getById(int $id, bool $withCategory = false): Product;
    public function getByColumn(string $column, mixed $value, bool $withCategory = false): ?Product;
    public function getByColumnOrFail(string $column, mixed $value, bool $withCategory = false): Product;
    public function paginate(int $total = 15, bool $withCategory = false): LengthAwarePaginator;
    public function getAll(bool $withCategory = false): Collection;
}
