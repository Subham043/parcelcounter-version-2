<?php

namespace App\Features\Roles\Controllers;

use App\Features\Roles\Interfaces\RoleServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Roles\Resources\RoleCollection;
use Illuminate\Http\Request;

class RolePaginateController extends Controller
{
    public function __construct(private RoleServiceInterface $roleService) {}

    /**
     * Returns a paginated collection of roles.
     *
     * @param Request $request
     * @return RoleCollection
     */
    public function index(Request $request)
    {
        $data = $this->roleService->paginate($request->total ?? 10);
        return RoleCollection::collection($data);
    }
}
