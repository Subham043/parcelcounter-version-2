<?php

namespace App\Features\Roles\Controllers;

use App\Features\Roles\DTO\RoleFilterDTO;
use App\Features\Roles\Interfaces\RoleServiceInterface;
use App\Features\Roles\Requests\RoleFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Roles\Resources\RoleCollection;

class RolePaginateController extends Controller
{
    public function __construct(private RoleServiceInterface $roleService) {}

    /**
     * Returns a paginated collection of roles.
     *
     * @param RoleFilterRequest $request
     * @return RoleCollection
     */
    public function index(RoleFilterRequest $request)
    {
        $data = $this->roleService->paginate(RoleFilterDTO::fromRequest($request));
        return RoleCollection::collection($data);
    }
}
