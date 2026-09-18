<?php

namespace App\Features\ProductSpecifications\Interfaces;

use App\Features\ProductSpecifications\Models\ProductSpecification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductSpecificationRepositoryInterface
{
    public function model(int $product_id): Builder;
    public function query(int $product_id): QueryBuilder;
    public function create(array $data, int $product_id): ProductSpecification;
    public function update(ProductSpecification $specification, array $data): ProductSpecification;
    public function delete(ProductSpecification $specification): ProductSpecification;
    public function getById(int $product_id, int $id): ProductSpecification;
    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductSpecification;
    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductSpecification;
    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator;
    public function getAll(int $product_id): Collection;
}
