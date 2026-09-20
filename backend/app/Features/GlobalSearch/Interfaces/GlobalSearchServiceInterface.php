<?php

namespace App\Features\GlobalSearch\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface GlobalSearchServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
}
