<?php

namespace App\Features\Roles\Services;

use App\Features\Roles\Interfaces\RoleServiceInterface;
use App\Features\Roles\Interfaces\RoleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService implements RoleServiceInterface
{
    public function __construct(private RoleRepositoryInterface $roleRepository) {}

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        return $this->roleRepository->paginate($total);
    }
}
