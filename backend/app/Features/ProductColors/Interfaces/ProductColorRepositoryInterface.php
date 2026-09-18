<?php

namespace App\Features\ProductColors\Interfaces;

use App\Features\ProductColors\Models\ProductColor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductColorRepositoryInterface
{
    public function model(int $product_id): Builder;
    public function query(int $product_id): QueryBuilder;
    public function create(array $data, int $product_id): ProductColor;
    public function update(ProductColor $color, array $data): ProductColor;
    public function delete(ProductColor $color): ProductColor;
    public function getById(int $product_id, int $id): ProductColor;
    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductColor;
    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductColor;
    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator;
    public function getAll(int $product_id): Collection;
}
