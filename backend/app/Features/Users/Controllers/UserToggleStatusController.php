<?php

namespace App\Features\Users\Controllers;

use App\Features\Users\Interfaces\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Users\Resources\UserCollection;

class UserToggleStatusController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Toggle the blocked status of an user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the user by the given ID, starts a database transaction,
     * and toggles the 'is_blocked' status of the user. It returns a JSON response
     * indicating whether the user was blocked or unblocked successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $user = $this->userService->getById($id);
        try {
            //code...
            $updated_user = $this->userService->toggleBlock($user);
            if ($updated_user->is_blocked) {
                return response()->json(["message" => "User blocked successfully.", "data" => UserCollection::make($updated_user)], 200);
            }
            return response()->json(["message" => "User unblocked successfully.", "data" => UserCollection::make($updated_user)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
