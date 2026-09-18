<?php

namespace App\Features\Account\Controllers;

use App\Features\Account\Resources\ProfileCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request){
        return response()->json([
            'token' => $request->bearerToken(),
            'profile' => ProfileCollection::make($request->user()),
        ], 200);
    }
}
