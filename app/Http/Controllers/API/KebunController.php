<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kebun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KebunController extends Controller
{
    //
    function tambah(Request $request){
        $token = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token === null || !$token) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{
            
            $validator = Validator::make($request->all(), [
                'id_user' => 'required',
                'id_tanaman' => 'required',
                'jenis_kebun' => 'required',
                'nama_kebun' => 'required',
                'nama_pemilik' => 'required',
                'id_perangkat' => 'required',
                'alamat' => 'required',
                'luas' => 'required',
                'satuan' => 'required',
                // 'foto' => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $kebun = Kebun::create([
                'id_user' => $request->id_user,
                'id_tanaman' => $request->id_tanaman,
                'jenis_kebun' => $request->jenis_kebun,
                'nama_kebun' => $request->nama_kebun,
                'nama_pemilik' => $request->nama_pemilik,
                'id_perangkat' => $request->id_perangkat,
                'alamat' => $request->alamat,
                'luas' => $request->luas,
                'satuan' => $request->satuan,
                'foto' => $request->foto,
                'tgl_dibuat' => $request->tgl_dibuat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'altitude' => $request->altitude,
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . ($request->nama_kebun) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('kebun_foto', $filename, 'public'); // Simpan foto di penyimpanan yang sesuai
                
                $kebun->foto = $filename;
                $kebun->save();
            }

            if ($kebun) {
                return response()->json([
                    'success' => true,
                    'tanaman' => $kebun
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "tambah data kebun gagal"
                ], 409);
            }
        }
    }

    function edit(Request $request, $id){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{
            $kebun = Kebun::find($id);

            if ($kebun) {
                Kebun::where('id', $id)->update([
                    'id_user' => $request->id_user,
                    'id_tanaman' => $request->id_tanaman,
                    'jenis_kebun' => $request->jenis_kebun,
                    'nama_kebun' => $request->nama_kebun,
                    'nama_pemilik' => $request->nama_pemilik,
                    'id_perangkat' => $request->id_perangkat,
                    'alamat' => $request->alamat,
                    'luas' => $request->luas,
                    'satuan' => $request->satuan,
                    'foto' => $request->foto,
                    'tgl_dibuat' => $request->tgl_dibuat,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'altitude' => $request->altitude,
                ]);

                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $filename = time() . '_' . ($request->nama_kebun) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('kebun_foto', $filename, 'public'); // Simpan foto di penyimpanan yang sesuai
                    
                    $kebun->foto = $filename;
                    $kebun->save();
                }    

                return response()->json([
                    'success' => true,
                    'message' => 'Item updated successfully', 
                    'data' => $kebun
                ]); 
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Item updated failled', 
                ]);
            }
        }
    }

    function show(Request $request){
        $user = User::where([
            'login_token' => $request->token
        ])->first();
        
        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);

        }else{
            $kebunData = Kebun::with(['user', 'tanaman', 'perangkat'])->get();

            $baseUrl = url('http://127.0.0.1:8000'); // Ambil base URL
        
            foreach ($kebunData as $kebun) {
                if ($kebun->tanaman->foto) {
                    $kebun->tanaman->foto = $baseUrl . '/storage/tanaman_foto/' . $kebun->tanaman->foto;
                }
                // Lakukan hal serupa untuk foto lainnya
            }
        
            return response()->json([
                'kebun' => $kebunData
            ]);
        

        }
    }

    function showid(Request $request, $id){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{

            $kebun = Kebun::where('id_user', $id)->with('user', 'tanaman', 'perangkat')->get();
            
            return response()->json([
                'kebun' => $kebun
            ], 200);
        }
    }

    function showidkebun(Request $request, $id){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{

            $kebunData = Kebun::where('id', $id)->with('user', 'tanaman', 'perangkat')->get();
        
            foreach ($kebunData as $kebun) {
                if ($kebun->tanaman->foto) {
                    $kebun->tanaman->foto = $kebun->tanaman->foto ? asset('storage/tanaman_foto/' . $kebun->tanaman->foto) : null;
                    $kebun->user->foto = $kebun->user->foto ? asset('storage/user_foto/' . $kebun->user->foto) : null;
                    // $kebun->foto = $kebun->foto ? asset('storage/kebun_foto/' . $kebun->foto) : null;
                }
            }
        
            return response()->json([
                'kebun' => $kebunData
            ]);
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
            $kebun = Kebun::find($id);

            $kebun->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kebun berhasil di hapus'
            ], 200);
        }
    }

}
