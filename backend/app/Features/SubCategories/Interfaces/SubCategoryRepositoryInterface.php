<?php

namespace App\Features\SubCategories\Interfaces;

use App\Features\SubCategories\Models\SubCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface SubCategoryRepositoryInterface
{
    public function model(bool $withCategory = false): Builder;
    public function query(bool $withCategory = false): QueryBuilder;
    public function create(array $data): SubCategory;
    public function update(SubCategory $subCategory, array $data): SubCategory;
    public function syncCategories(SubCategory $subCategory, array $data): SubCategory;
    public function delete(SubCategory $subCategory): SubCategory;
    public function getById(int $id, bool $withCategory = false): SubCategory;
    public function getByColumn(string $column, mixed $value, bool $withCategory = false): ?SubCategory;
    public function getByColumnOrFail(string $column, mixed $value, bool $withCategory = false): SubCategory;
    public function paginate(int $total = 15, bool $withCategory = false): LengthAwarePaginator;
    public function getAll(bool $withCategory = false): Collection;
}
