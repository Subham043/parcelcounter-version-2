<?php

namespace App\Features\GlobalSearch\Interfaces;

use App\Features\GlobalSearch\DTO\GlobalSearchFilterDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface GlobalSearchRepositoryInterface
{
    public function model(?GlobalSearchFilterDTO $dto = null): Builder;
    public function query(?GlobalSearchFilterDTO $dto = null): QueryBuilder;
    public function paginate(?GlobalSearchFilterDTO $dto = null): LengthAwarePaginator;
}
