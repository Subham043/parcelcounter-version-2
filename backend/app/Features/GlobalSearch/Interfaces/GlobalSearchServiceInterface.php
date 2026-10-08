<?php

namespace App\Features\GlobalSearch\Interfaces;

use App\Features\GlobalSearch\DTO\GlobalSearchFilterDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface GlobalSearchServiceInterface
{
    public function paginate(?GlobalSearchFilterDTO $dto = null): LengthAwarePaginator;
}
