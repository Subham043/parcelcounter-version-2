<?php

namespace App\Features\Blogs\Interfaces;

use App\Features\Blogs\DTO\BlogFilterDTO;
use App\Features\Blogs\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface BlogRepositoryInterface
{
    public function model(?BlogFilterDTO $dto = null): Builder;
    public function query(?BlogFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): Blog;
    public function update(Blog $blog, array $data): Blog;
    public function delete(Blog $blog): Blog;
    public function getById(int $id): Blog;
    public function getByColumn(string $column, mixed $value): ?Blog;
    public function getByColumnOrFail(string $column, mixed $value): Blog;
    public function paginate(?BlogFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?BlogFilterDTO $dto = null): Collection;
}
