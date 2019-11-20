<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserController extends Controller
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

    public function dataUsers()
    {
        $users = User::with('profile')->latest()->paginate(20);

        $data = [
            'code' => 1,
            'message' => '',
            'data' => $users
        ];

        return response()->json($data, 200);
    }

    public function addUser(Request $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        $profile = new UserProfile();
        $profile->user_id = $user->id;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->gender = $request->gender;
        $profile->save();

        $data = [
            'code' => 1,
            'message' => 'User Berhasil Ditambahkan',
            'data' => []
        ];

        return response()->json($data, 200);
    }

    public function profileUser($userId)
    {
        $user = User::with('profile')->find($userId);

        $data = [
            'code' => 200,
            'message' => '',
            'data' => $user
        ];

        return response()->json($data, 200);
    }

    public function updateProfileUser(Request $request, $userId)
    {
        $profile = UserProfile::where('user_id', $userId)->first();
        if ($request->first_name) {
            $profile->first_name = $request->first_name;
        }
        if ($request->last_name) {
            $profile->last_name = $request->last_name;
        }
        if ($request->gender) {
            $profile->gender = $request->gender;
        }
        $profile->save();

        $data = [
            'code' => 1,
            'message' => 'User Berhasil DiUpdate',
            'data' => []
        ];

        return response()->json($data, 200);
    }

    public function toMale(Request $request, $userId) 
    {
        try {
            DB::beginTransaction();

            $profile = UserProfile::where('user_id', $userId)->first();
            $profile->update([
                'gender' => config('gender.male')
            ]);

            $data = [
                'code' => 1,
                'message' => 'Sukses',
                'data' => []
            ];

            DB::commit();
        } catch(Exception $e) {
            Log::error($e);
            DB::rollback();

            $data = [
                'code' => 2,
                'message' => Profile::FEMALE,
                'data' => []
            ];
        }

        return response()->json($data, 200);
    }

    public function toFemale(Request $request, $userId) 
    {
        try {
            DB::beginTransaction();

            $profile = UserProfile::where('user_id', $userId)->first();
            $profile->update([
                'gender' => 'female'
            ]);

            $data = [
                'code' => 1,
                'message' => 'Sukses',
                'data' => []
            ];

            DB::commit();
        } catch(Exception $e) {
            Log::error($e);
            DB::rollback();

            $data = [
                'code' => 2,
                'message' => 'Gagal',
                'data' => []
            ];
        }

        return response()->json($data, 200);
    }

    public function delete(Request $request, $userId) 
    {
        try {
            DB::beginTransaction();

            $profile = UserProfile::where('user_id', $userId)->firstOrFail();
            $profile->delete();

            $data = [
                'code' => 1,
                'message' => 'Sukses',
                'data' => []
            ];

            DB::commit();
        } catch(Exception $e) {
            Log::error($e);
            DB::rollback();

            $data = [
                'code' => 2,
                'message' => 'Gagal',
                'data' => []
            ];
        }

        return response()->json($data, 200);
    }
}
