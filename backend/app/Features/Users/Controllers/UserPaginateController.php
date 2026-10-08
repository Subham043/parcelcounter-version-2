<?php

namespace App\Features\Users\Controllers;

use App\Features\Users\DTO\UserFilterDTO;
use App\Features\Users\Interfaces\UserServiceInterface;
use App\Features\Users\Requests\UserFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Users\Resources\UserCollection;

class UserPaginateController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Returns a paginated collection of users.
     *
     * @param UserFilterRequest $request
     * @return UserCollection
     */
    public function index(UserFilterRequest $request)
    {
        $data = $this->userService->paginate(UserFilterDTO::fromRequest($request));
        return UserCollection::collection($data);
    }
}
