<?php

namespace App\Features\Categories\Interfaces;

use App\Features\Categories\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface CategoryRepositoryInterface
{
    public function model(bool $isSelect = false): Builder;
    public function query(bool $isSelect = false): QueryBuilder;
    public function create(array $data): Category;
    public function update(Category $category, array $data): Category;
    public function delete(Category $category): Category;
    public function getById(int $id): Category;
    public function getByColumn(string $column, mixed $value): ?Category;
    public function getByColumnOrFail(string $column, mixed $value): Category;
    public function paginate(int $total = 15, bool $isSelect = false): LengthAwarePaginator;
    public function getAll(bool $isSelect = false): Collection;
}
