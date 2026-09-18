<?php

namespace App\Features\Authentication\Controllers;

use App\Features\Authentication\Requests\ForgotPasswordPostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    public function index(ForgotPasswordPostRequest $request){

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'message' => __($status),
        ], $status === Password::ResetLinkSent ? 200 : 400);
    }
}
