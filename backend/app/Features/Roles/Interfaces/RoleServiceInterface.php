<?php

namespace App\Features\Roles\Interfaces;

use App\Features\Roles\DTO\RoleFilterDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoleServiceInterface
{
    public function paginate(?RoleFilterDTO $dto = null): LengthAwarePaginator;
}
