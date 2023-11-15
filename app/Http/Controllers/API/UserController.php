<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required|min:10',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $request->id . $file->getClientOriginalName();
            $file->storeAs('user_foto', $filename, 'public'); // Simpan foto di penyimpanan yang sesuai
            
            $user->foto = $filename;
            $user->save();
        }

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => "register gagal"
        ], 409);
    }

    function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        $token = auth()->guard('api')->attempt($credentials);
        $user = auth()->guard('api')->user();

        $login_token = tap(User::where([
            'email' => $request->email,
        ]))->update([
            'login_token' => $token
        ])->first();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password anda salah'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    function logout(Request $request){
        if ($request->token == null) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }

        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if (!$user){
            return response()->json([
                'success' => false,
                'message' => 'User failled signed out'
            ], 200);
        }

        $token = auth()->guard('api')->login($user);

        if ($user) {

            $logout_token = tap(User::where([
                'login_token' => $request->token,
            ]))->update([
                'login_token' => $token
            ])->first();

            auth()->guard('api')->logout($user);

            return response()->json([
                'success' => true,
                'message' => 'User successfully signed out'
            ], 200);
        }
    }

    function show(Request $request){
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

    function update(Request $request,  $id){
        $token = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token == null || !$token) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{
            $validator = Validator::make($request->all(), [
                // 'name' => '',
                // 'email' => 'email|',
                // 'password' => 'min:6',
                // // 'alamat' => 'required',
                // // 'jenis_kelamin' => 'required',
                // 'no_hp' => 'min:10',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::where('id', $id)->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

                $userUpdate = User::where('id', $id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'no_hp' => $request->no_hp,
                ]);

                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $filename = time() . '_' . $request->id . $file->getClientOriginalName();
                    $file->storeAs('user_foto', $filename, 'public'); // Simpan foto di penyimpanan yang sesuai
                    
                    $user->foto = $filename;
                    $user->save();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Item updated successfully', 
                    'data' => $user
                ], 200);
        }
    }

    function updateRegist(Request $request,  $id){
        $validator = Validator::make($request->all(), [
            // 'name' => '',
            // 'email' => 'email|',
            // 'password' => 'min:6',
            // // 'alamat' => 'required',
            // // 'jenis_kelamin' => 'required',
            // 'no_hp' => 'min:10',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

            $userUpdate = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $request->id . $file->getClientOriginalName();
                $file->storeAs('user_foto', $filename, 'public'); // Simpan foto di penyimpanan yang sesuai
                
                $user->foto = $filename;
                $user->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully', 
                'data' => $user
            ], 200);
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
            $user = User::where('id', $id)->first();

            if ($user) {
                $userWithFoto = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'alamat' => $user->alamat,
                    'jenis_kelamin' => $user->jenis_kelamin,
                    'no_hp' => $user->no_hp,
                    'foto' => $user->foto ? asset('storage/user_foto/' . $user->foto) : null,
                ];

                return response()->json([
                    'success' => true,
                    'user' => $userWithFoto
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

        }
    }

    function hapus(Request $request, $id){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{
            $info = User::find($id);

            $info->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil di hapus'
            ], 200);
        }
    }

}
