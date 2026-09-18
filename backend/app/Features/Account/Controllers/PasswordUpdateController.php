<?php

namespace App\Features\Account\Controllers;

use App\Features\Account\Requests\PasswordUpdatePostRequest;
use App\Http\Controllers\Controller;

class PasswordUpdateController extends Controller
{
    public function index(PasswordUpdatePostRequest $request){
        try {
            //code...
             $request->user()->update($request->safe()->only('password'));

            return response()->json([
                'message' => "Password Updated successfully.",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "something went wrong. Please try again.",
            ], 400);
        }
    }
}
