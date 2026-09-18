<?php

namespace App\Features\Users\Interfaces;

use App\Features\Users\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface UserRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): User;
    public function getById(int $id): User;
    public function getByColumn(string $column, mixed $value): ?User;
    public function getByColumnOrFail(string $column, mixed $value): User;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
