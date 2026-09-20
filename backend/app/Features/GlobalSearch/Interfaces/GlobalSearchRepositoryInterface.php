<?php

namespace App\Features\GlobalSearch\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface GlobalSearchRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function paginate(int $total = 15): LengthAwarePaginator;
}
