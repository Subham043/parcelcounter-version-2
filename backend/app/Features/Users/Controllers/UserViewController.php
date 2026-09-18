<?php

namespace App\Features\Users\Controllers;

use App\Features\Users\Interfaces\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Users\Resources\UserCollection;

class UserViewController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = $this->userService->getById($id);
        return response()->json(["message" => "User fetched successfully.", "data" => UserCollection::make($user)], 200);
    }
}
