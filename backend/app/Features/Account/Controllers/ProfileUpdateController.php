<?php

namespace App\Features\Account\Controllers;

use App\Features\Account\Requests\ProfileUpdatePostRequest;
use App\Features\Account\Resources\ProfileCollection;
use App\Features\Authentication\Services\AuthCache;
use App\Http\Controllers\Controller;
use App\Http\Enums\Guards;

class ProfileUpdateController extends Controller
{
    public function index(ProfileUpdatePostRequest $request){
        try {
            //code...
            $user = $request->user();

            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();
            }

            $user->save();

            $cachedUser = AuthCache::getCachedUser(Guards::API);

            return response()->json([
                'profile' => ProfileCollection::make($cachedUser),
                'message' => "Profile Updated successfully.",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "something went wrong. Please try again.",
            ], 400);
        }
    }
}
