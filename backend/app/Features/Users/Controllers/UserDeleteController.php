<?php

namespace App\Features\Users\Controllers;

use App\Features\Users\Interfaces\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Users\Resources\UserCollection;

class UserDeleteController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Delete a user
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $user = $this->userService->getById($id);
        try {
            //code...
            $this->userService->delete($user);
            return response()->json(["message" => "User deleted successfully.", "data" => UserCollection::make($user)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
