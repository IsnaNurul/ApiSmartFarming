<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PetaniController extends Controller
{
    //
    function showall(Request $request){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token == null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{
            return response()->json([
                'success' => true,
                'user' => User::all()
            ], 200);
        }
    }

    function showadmin(Request $request){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token == null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{
            return response()->json([
                'success' => true,
                'user' => User::where('role', 'admin')->get()
            ], 200);
        }
    }

    function showmember(Request $request){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token == null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{

            $user = User::where('role', 'member')->get();

            foreach ($user as $userData) {
                if ($userData->foto) {
                    $userData->foto = $userData->foto ? asset('storage/user_foto/' . $userData->foto) : null;
                }
            }

            return response()->json([
                'success' => true,
                'user' => $user
            ], 200);
        }
    }

    function showid(Request $request, $id){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token == null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{
            return response()->json([
                'success' => true,
                'petani' => User::where('id', $id)->get()
            ], 200);
        }
    }
}
