<?php

namespace App\Features\Roles\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RoleServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
}
