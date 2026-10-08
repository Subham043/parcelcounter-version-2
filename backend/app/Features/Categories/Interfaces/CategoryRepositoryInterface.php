<?php

namespace App\Features\Categories\Interfaces;

use App\Features\Categories\DTO\CategoryFilterDTO;
use App\Features\Categories\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface CategoryRepositoryInterface
{
    public function model(?CategoryFilterDTO $dto = null): Builder;
    public function query(?CategoryFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): Category;
    public function update(Category $category, array $data): Category;
    public function delete(Category $category): Category;
    public function getById(int $id): Category;
    public function getByColumn(string $column, mixed $value): ?Category;
    public function getByColumnOrFail(string $column, mixed $value): Category;
    public function paginate(?CategoryFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?CategoryFilterDTO $dto = null): Collection;
}
