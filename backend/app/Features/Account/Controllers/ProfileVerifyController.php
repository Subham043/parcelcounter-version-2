<?php

namespace App\Features\Account\Controllers;

use App\Features\Account\Requests\EmailVerificationRequest;
use App\Http\Controllers\Controller;

class ProfileVerifyController extends Controller
{
    public function index(EmailVerificationRequest $request)
    {
        $clientUrl = rtrim(config('app.client_url'), '/');
        $request->fulfill();
        if ($request->userInfo()->hasVerifiedEmail()) {
            return redirect($clientUrl . '?verified=true');
        }
        return redirect($clientUrl);
    }
}
