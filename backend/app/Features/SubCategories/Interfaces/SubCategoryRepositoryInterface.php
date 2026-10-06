<?php

namespace App\Features\SubCategories\Interfaces;

use App\Features\SubCategories\DTO\SubCategoryFilterDTO;
use App\Features\SubCategories\Models\SubCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface SubCategoryRepositoryInterface
{
    public function model(?SubCategoryFilterDTO $dto = null): Builder;
    public function query(?SubCategoryFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): SubCategory;
    public function update(SubCategory $subCategory, array $data): SubCategory;
    public function syncCategories(SubCategory $subCategory, array $data): SubCategory;
    public function delete(SubCategory $subCategory): SubCategory;
    public function getById(int $id, ?SubCategoryFilterDTO $dto = null): SubCategory;
    public function getByColumn(string $column, mixed $value, ?SubCategoryFilterDTO $dto = null): ?SubCategory;
    public function getByColumnOrFail(string $column, mixed $value, ?SubCategoryFilterDTO $dto = null): SubCategory;
    public function paginate(?SubCategoryFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?SubCategoryFilterDTO $dto = null): Collection;
}
