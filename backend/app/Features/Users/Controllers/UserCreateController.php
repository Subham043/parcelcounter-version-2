<?php

namespace App\Features\Users\Controllers;

use App\Features\Users\DTO\UserCreateDTO;
use App\Features\Users\DTO\UserRoleDTO;
use App\Features\Users\Interfaces\UserServiceInterface;
// use App\Features\Users\DTO\UserRoleDTO;
use App\Features\Users\Notifications\AdminVerifyEmailNotification;
use App\Http\Controllers\Controller;
use App\Features\Users\Requests\UserCreatePostRequest;
use App\Features\Users\Resources\UserCollection;

class UserCreateController extends Controller
{

    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(UserCreatePostRequest $request)
    {
        try {
            //code...
            $user = $this->userService->create(
                UserCreateDTO::fromRequest($request),
                UserRoleDTO::fromRequest($request)
            );
            // $this->userService->syncRoles($user, [UserRoleDTO::fromRequest($request)]);
            // $user->notify(new AdminVerifyEmailNotification(
            //     createdByAdmin: true,
            //     plainPassword: $request->password
            // ));
            return response()->json([
                "message" => "User created successfully.",
                "data" => UserCollection::make($user),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
