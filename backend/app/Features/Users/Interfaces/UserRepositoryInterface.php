<?php

namespace App\Features\Users\Interfaces;

use App\Features\Users\DTO\UserFilterDTO;
use App\Features\Users\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface UserRepositoryInterface
{
    public function model(?UserFilterDTO $dto = null): Builder;
    public function query(?UserFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): User;
    public function getById(int $id): User;
    public function getByColumn(string $column, mixed $value): ?User;
    public function getByColumnOrFail(string $column, mixed $value): User;
    public function paginate(?UserFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?UserFilterDTO $dto = null): Collection;
}
