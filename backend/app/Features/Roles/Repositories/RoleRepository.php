<?php

namespace App\Features\Roles\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;
use App\Features\Roles\Enums\Roles;
use App\Features\Roles\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    protected $employee_roles = [
        Roles::SuperAdmin,
        Roles::Staff,
        Roles::ContentManager,
        Roles::InventoryManager,
        Roles::WarehouseManager,
        Roles::User,
        Roles::DeliveryAgent,
        Roles::AppPromoter,
        Roles::RewardRiders,
        Roles::ReferralRockstars
    ];

    public function model(): Builder
    {
        return Role::select('id', 'name')->whereIn('name', $this->employee_roles);
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort('-id')
            ->allowedSorts('id', 'name')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
            ]);
    }

    public function paginate(int $total = 15): LengthAwarePaginator
    {
        return $this->query()->paginate($total)->appends(request()->query());
    }
}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
