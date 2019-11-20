<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProfile;

class MaleFemaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function getProfile($userId){
        $user = User::with('profile')->find($userId);

        $data = [
            'code' => 200,
            'message' => 'Hallo '.$user['profile']['gender'],
            'data' => $user
        ];

        return response()->json($data, 200);        
    }
}
