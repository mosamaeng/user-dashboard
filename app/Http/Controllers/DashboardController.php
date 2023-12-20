<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try{
            $users = new User;

            $users = $users->search($request)->get();
            
            // for api request
            if($request->wantsJson()){
                $usersArray = $users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'impression_count' => $user->impression_count,
                        'conversion_count' => $user->conversion_count,
                        'revenue' => $user->revenue,
                        'conversion_per_day' => $user->conversion_per_day,
                    ];
                });
        
                return response()->json($usersArray);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
        return view('dashboard', compact('users'));
    }
}
