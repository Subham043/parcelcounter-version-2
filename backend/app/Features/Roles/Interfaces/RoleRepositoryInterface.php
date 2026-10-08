<?php

namespace App\Features\Roles\Interfaces;

use App\Features\Roles\DTO\RoleFilterDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface RoleRepositoryInterface
{
    public function model(?RoleFilterDTO $dto = null): Builder;
    public function query(?RoleFilterDTO $dto = null): QueryBuilder;
    public function paginate(?RoleFilterDTO $dto = null): LengthAwarePaginator;
}
