<?php

namespace App\Features\Authentication\Controllers;

use App\Features\Authentication\Requests\ResetPasswordPostRequest;
use App\Features\Users\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{

    public function index(ResetPasswordPostRequest $request, string $token)
    {

        $status = Password::reset(
            [...$request->only('email', 'password', 'password_confirmation'), 'token' => $token],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json([
            'message' => __($status),
        ], $status === Password::PasswordReset ? 200 : 400);
    }
}
