<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TanamanController extends Controller
{
    //
    // function tambah(Request $request){
    //     $user = User::where([
    //         'login_token' => $request->token
    //     ])->first();

    //     if ($request->token === null || !$user) {
    //         return response()->json([
    //             'message' => 'Unauthorisation User'
    //         ], 401);
    //     }else{
            
    //         $validator = Validator::make($request->all(), [
    //             'nama' => 'required|unique:tanamen',
    //             'jenis' => 'required',
    //             'musim' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json($validator->errors(), 422);
    //         }

    //         $perangkat = Tanaman::create([
    //             'nama' => $request->nama,
    //             'jenis' => $request->jenis,
    //             'musim' => $request->musim,
    //         ]);

    //         if ($perangkat) {
    //             return response()->json([
    //                 'success' => true,
    //                 'tanaman' => $perangkat
    //             ], 201);
    //         }else{
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => "tambah data Perangkat gagal"
    //             ], 409);
    //         }
    //     }
    // }

    function tambah(Request $request){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorised User'
            ], 401);
        } else {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|unique:tanamen',
                'jenis' => 'required',
                'deskripsi' => 'required',
                // 'musim' => 'required',
                // 'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $tanaman = Tanaman::create([
                'nama' => $request->nama,     
                'jenis' => $request->jenis,
                'musim' => $request->musim,
                'deskripsi' => $request->deskripsi,
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . ($request->nama) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('tanaman_foto', $filename, 'public'); // Simpan foto di penyimpanan yang sesuai
                
                $tanaman->foto = $filename;
                $tanaman->save();
            }

            if ($tanaman) {
                return response()->json([
                    'success' => true,
                    'tanaman' => $tanaman
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "tambah data Perangkat gagal"
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
            $tanaman = Tanaman::find($id);

            if ($tanaman) {
                Tanaman::where('id', $id)->update([
                    'nama' => $request->nama,
                    'jenis' => $request->jenis,
                    'musim' => $request->musim,
                ]);

                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $filename = time() . '_' . ($request->nama) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('tanaman_foto', $filename, 'public'); // Simpan foto di penyimpanan yang sesuai
                    
                    $tanaman->foto = $filename;
                    $tanaman->save();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Item updated successfully', 
                    'data' => $tanaman
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
            $tanaman = Tanaman::all();

            $tanamanWithPhotos = [];
            foreach ($tanaman as $t) {
                $tanamanWithPhotos[] = [
                    'id' => $t->id,
                    'nama' => $t->nama,
                    'jenis' => $t->jenis,
                    'musim' => $t->musim,
                    'foto' => $t->foto ? asset('storage/tanaman_foto/' . $t->foto) : null,
                ];
            }

            return response()->json([
                'success' => true,
                'tanaman' => $tanamanWithPhotos
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
            $tanaman = Tanaman::where('id', $id)->first();

            // $tanamanWithPhotos = [];
            // foreach ($tanaman as $t) {
            //     $tanamanWithPhotos[] = [
            //         'id' => $t->id,
            //         'nama' => $t->nama,
            //         'jenis' => $t->jenis,
            //         'musim' => $t->musim,
            //         'foto' => $t->foto ? asset('storage/tanaman_foto/' . $t->foto) : null,
            //     ];
            // }

            return response()->json([
                'success' => true,
                'tanaman' => $tanaman
            ], 200);
        }
    }

    function hapus(Request $request, $id) {
        $user = User::where([
            'login_token' => $request->token
        ])->first();
    
        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorised User'
            ], 401);
        } else {
            $tanaman = Tanaman::find($id);
    
            if (!$tanaman) {
                return response()->json([
                    'message' => 'Data not found'
                ], 404);
            }
    
            // Mendapatkan nama file foto
            $namaFoto = $tanaman->foto;
    
            // Hapus file dari public storage
            Storage::delete(asset('storage/tanaman_foto') . $namaFoto);
    
            // Hapus data dari database
            $tanaman->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Kebun berhasil dihapus'
            ], 200);
        }
    }
    
    
}
