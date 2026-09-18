<?php

namespace App\Features\Users\Controllers;

use App\Http\Controllers\Controller;
use App\Features\Users\Resources\UserCollection;
use Illuminate\Auth\Events\Verified;
use App\Features\Authentication\Services\AuthCache;
use App\Features\Users\Interfaces\UserServiceInterface;

class UserToggleVerificationController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    /**
     * Toggle the verification status of an user.
     *
     * @param int $id The ID of the user to verify.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     * 
     * If the user is already verified, the response will indicate so.
     * If the verification is successful, the response will include the updated user data.
     * In case of failure, the response will return an error message.
     */

    public function index($id)
    {
        $user = $this->userService->getById($id);
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            AuthCache::forget($user->id);
            return response()->json(["message" => "User verified successfully.", "data" => UserCollection::make($user)], 200);
        }
        return response()->json(["message" => "User already verified."], 400);
    }
}
