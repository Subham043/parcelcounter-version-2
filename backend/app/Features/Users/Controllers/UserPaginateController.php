<?php

namespace App\Features\Users\Controllers;

use App\Features\Users\Interfaces\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Users\Resources\UserCollection;
use Illuminate\Http\Request;

class UserPaginateController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Returns a paginated collection of users.
     *
     * @param Request $request
     * @return UserCollection
     */
    public function index(Request $request)
    {
        $data = $this->userService->paginate($request->total ?? 10);
        return UserCollection::collection($data);
    }
}
