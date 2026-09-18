<?php

namespace App\Features\Roles\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface RoleRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function paginate(int $total = 15): LengthAwarePaginator;
}
