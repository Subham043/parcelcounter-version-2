<?php

namespace App\Features\Roles\Repositories;

use App\Features\Roles\DTO\RoleFilterDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Features\Roles\Enums\Roles;
use App\Features\Roles\Interfaces\RoleRepositoryInterface;
use App\Http\CommonFilters\SearchFilter;
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

    private const SEARCH_COLUMNS = [
        'name',
    ];

    private const SORT_COLUMNS = [
        'id',
        ...self::SEARCH_COLUMNS,
    ];

    public function model(?RoleFilterDTO $dto = null): Builder
    {
        return Role::select(...self::SORT_COLUMNS)->whereIn('name', $this->employee_roles);
    }

    public function query(?RoleFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? 'name')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
            ]);
    }

    public function paginate(?RoleFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }
}
