<?php

namespace App\Features\Account\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileResendVerificationController extends Controller
{
    public function index(Request $request){
        if($request->user()->hasVerifiedEmail()){
            return response()->json([
                'message' => 'Email already verified!',
            ], 200);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'Verification link sent!',
        ], 200);
    }
}
