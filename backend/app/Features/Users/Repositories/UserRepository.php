<?php

namespace App\Features\Users\Repositories;


use App\Features\Users\Models\User;
use App\Features\Users\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class UserRepository implements UserRepositoryInterface
{
    public function model(): Builder
    {
        return User::select('id', 'name', 'email', 'phone', 'email_verified_at', 'phone_verified_at', 'is_blocked', 'created_at', 'updated_at')->with(['roles' => function ($query) {
            $query->select('id', 'name');
        }]);
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort('-id')
            ->allowedSorts('id', 'name')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
                AllowedFilter::callback('is_blocked', function (Builder $query, $value) {
                    if (strtolower($value) == "yes") {
                        $query->where('is_blocked', true);
                    }
                    if (strtolower($value) == "no") {
                        $query->where('is_blocked', false);
                    }
                }),
                AllowedFilter::callback('is_verified', function (Builder $query, $value) {
                    if (strtolower($value) == "yes") {
                        $query->whereNotNull('phone_verified_at');
                    }
                    if (strtolower($value) == "no") {
                        $query->whereNull('phone_verified_at');
                    }
                }),
                AllowedFilter::callback('role', function (Builder $query, $value) {
                    $query->whereHas('roles', function ($q) use ($value) {
                        $q->where('name', $value);
                    });
                }),
            ]);
    }

    public function create(array $data): User
    {
        return $this->model()->create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->refresh();
    }

    public function delete(User $user): User
    {
        $user->delete();
        return $user;
    }

    public function getById(int $id): User
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?User
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): User
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(int $total = 15): LengthAwarePaginator
    {
        return $this->query()->paginate($total)->appends(request()->query());
    }

    public function getAll(): Collection
    {
        return $this->query()->lazy(100)->collect();
    }
}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->where(function ($q) use ($value) {
            $q->where('email', $value)
                ->orWhere('phone', $value)
                ->orWhereRaw('MATCH(name, email, phone) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
