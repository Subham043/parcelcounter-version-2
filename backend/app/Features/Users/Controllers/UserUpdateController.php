<?php

namespace App\Features\Users\Controllers;

// use App\Features\Users\DTO\UserRoleDTO;
use App\Features\Users\DTO\UserUpdateDTO;
use App\Features\Users\Interfaces\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Users\Requests\UserUpdatePostRequest;
use App\Features\Users\Resources\UserCollection;

class UserUpdateController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Update an user
     *
     * @param UserUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserUpdatePostRequest $request, $id)
    {
        $user = $this->userService->getById($id);
        try {
            //code...
            $updated_user = $this->userService->update(
                UserUpdateDTO::fromRequest($request),
                $user
            );
            // $this->userService->syncRoles($updated_user, [UserRoleDTO::fromRequest($request)]);
            return response()->json(["message" => "User updated successfully.", "data" => UserCollection::make($updated_user)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
