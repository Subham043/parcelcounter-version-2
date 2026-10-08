<?php

namespace App\Features\Users\Repositories;

use App\Features\Users\DTO\UserFilterDTO;
use App\Features\Users\Models\User;
use App\Features\Users\Interfaces\UserRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class UserRepository implements UserRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'email',
        'phone',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'email', 'phone', 'email_verified_at', 'phone_verified_at', 'is_blocked', 'created_at', 'updated_at'
        ];
    }
    public function model(?UserFilterDTO $dto = null): Builder
    {
        return User::select(...$this->getSelectColumns())->with(['roles' => function ($query) {
            $query->select(...self::SORT_COLUMNS);
        }]);
    }

    public function query(?UserFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_blocked', new BooleanFilter),
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

    public function paginate(?UserFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?UserFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
