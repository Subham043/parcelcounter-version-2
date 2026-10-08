<?php

namespace App\Features\Roles\Services;

use App\Features\Roles\DTO\RoleFilterDTO;
use App\Features\Roles\Interfaces\RoleServiceInterface;
use App\Features\Roles\Interfaces\RoleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService implements RoleServiceInterface
{
    public function __construct(private RoleRepositoryInterface $roleRepository) {}

    public function paginate(?RoleFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->roleRepository->paginate($dto);
    }
}
