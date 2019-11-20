<?php

namespace App\Http\Middleware;

use App\UserProfile;
use Closure;
use Illuminate\Support\Facades\DB;

class FeMaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            //$profile = UserProfile::where('user_id', $request->route('userId'))->firstorFail();

            $profile = DB::table('user_profiles')->where('user_id',$request->route('userId'))->get();

            //var_dump($profile);
            
            if($profile->count() > 0){
                
                if ($profile[0]->gender != UserProfile::FEMALE) {
                    $data = [
                        'code' => 403,
                        'message' => 'Ini Hanya Untuk Wanita',
                        'data' => []
                    ];
                    return response()->json($data, 403);    
                } 
            }else{
                $data = [
                    'code' => 404,
                    'message' => 'Data Not Found',
                    'data' => []
                ];
                return response()->json($data, 404);  
            }
           
        } catch(Exception $e) {
            $data = [
                'code' => 500,
                'message' => 'Internal Server Error',
                'data' => []
            ];
            return response()->json($data, 500);
        }

        return $next($request);
    }
}
