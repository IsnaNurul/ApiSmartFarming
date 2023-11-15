<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Log_activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivityController extends Controller
{

    public function logLogin($userId)
    {
        // Mendapatkan pengguna yang sedang login
        $user = User::where('id', $userId)->first();

        if (!$user) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $actionType = 'login';
        $timetamps = now('Asia/Jakarta');

        // Menambahkan deskripsi berdasarkan peran pengguna
        $description = '';
        if ($user->role === "member") {
            $description = 'Login Mobile';
        } elseif ($user->role === "admin") {
            $description = 'Login Web';
        }

        Log_activity::create([
            'id_user' => $userId,
            'deskripsi' => $description,
            'action_type' => $actionType,
            'timetamps' => $timetamps,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Log-in activity recorded'
        ]);
    }

    public function logLogout($userId)
    {
        // Mendapatkan pengguna yang sedang login
        $user = User::where('id', $userId)->first();

        if (!$user) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $actionType = 'logout';
        $timetamps = now('Asia/Jakarta');

        // Menambahkan deskripsi berdasarkan peran pengguna
        $description = '';
        if ($user->role === "member") {
            $description = 'Logout Mobile';
        } elseif ($user->role === "admin") {
            $description = 'Logout Web';
        }

        Log_activity::create([
            'id_user' => $userId,
            'deskripsi' => $description,
            'action_type' => $actionType,
            'timetamps' => $timetamps,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Log-out activity recorded'
        ]);
    }

    public function logShow(Request $request)
    {
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token == null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{

            $logAktivitas = Log_activity::with('user')->get();

            return response()->json([
                'success' => true,
                'log_aktivitas' => $logAktivitas
            ], 200);
        }
    }

}
