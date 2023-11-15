<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    //
    function tambah(Request $request){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{
            
            $validator = Validator::make($request->all(), [
                'judul' => 'required|unique:informasis',
                'deskripsi' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $informasi = Informasi::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('informasi_foto', $filename, 'public');
                
                $informasi->foto = $filename;
                $informasi->save();
            }

            if ($informasi) {
                return response()->json([
                    'success' => true,
                    'informasi' => $informasi
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "tambah data informasi gagal"
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
            $informasi = Informasi::find($id);

            if ($informasi) {
                Informasi::where('id', $id)->update([
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'tanggal' => $request->tanggal,
                    'foto' => $request->foto
                ]);

                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('informasi_foto', $filename, 'public'); // Simpan foto di penyimpanan yang sesuai
                    
                    $informasi->foto = $filename;
                    $informasi->save();
                }
    

                return response()->json([
                    'success' => true,
                    'message' => 'Item updated successfully', 
                    'informasi' => $informasi
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
            $informasi = Informasi::all();
        
            foreach ($informasi as $info) {
                if ($info->foto) {
                    $info->foto = $info->foto ? asset('storage/informasi_foto/' . $info->foto) : null;
                }
            }
        
            return response()->json([
                'informasi' => $informasi
            ]);
            
            return response()->json([
                'informasi' => $info
            ], 200);

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

            $informasi = Informasi::where('id', $id)->get();
            
            foreach ($informasi as $info) {
                if ($info->foto) {
                    $info->foto = $info->foto ? asset('storage/informasi_foto/' . $info->foto) : null;
                }
            }
        
            
            return response()->json([
                'informasi' => $informasi
            ], 200);
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
            $info = Informasi::find($id);

            $info->delete();

            return response()->json([
                'success' => true,
                'message' => 'Informasi berhasil di hapus'
            ], 200);
        }
    }

}
