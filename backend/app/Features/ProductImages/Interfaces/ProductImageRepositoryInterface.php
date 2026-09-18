<?php

namespace App\Features\ProductImages\Interfaces;

use App\Features\ProductImages\Models\ProductImage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductImageRepositoryInterface
{
    public function model(int $product_id): Builder;
    public function query(int $product_id): QueryBuilder;
    public function create(array $data, int $product_id): ProductImage;
    public function update(ProductImage $image, array $data): ProductImage;
    public function delete(ProductImage $image): ProductImage;
    public function getById(int $product_id, int $id): ProductImage;
    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductImage;
    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductImage;
    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator;
    public function getAll(int $product_id): Collection;
}
