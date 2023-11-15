<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kebun;
use App\Models\Perangkat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PerangkatController extends Controller
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
                'no_seri' => 'required|unique:perangkats',
                'versi' => 'required|',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $perangkat = Perangkat::create([
                'no_seri' => $request->no_seri,
                'id_user' => $request->id_user,
                'tgl_produksi' => $request->tgl_produksi,
                'tgl_aktivasi' => $request->tgl_aktivasi,
                'tgl_pembelian' => $request->tgl_pembelian,
                'versi' => $request->versi,
                'foto' => $request->foto,
            ]);

            if ($perangkat) {
                return response()->json([
                    'success' => true,
                    'perangkat' => $perangkat
                ], 201);
            }else{
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
            $perangkat = Perangkat::find($id);

            if ($perangkat) {
                Perangkat::where('id', $id)->update([
                    'no_seri' => $request->no_seri,
                    'id_user' => $request->id_user,
                    'tgl_produksi' => $request->tgl_produksi,
                    'tgl_aktivasi' => $request->tgl_aktivasi,
                    'tgl_pembelian' => $request->tgl_pembelian,
                    'versi' => $request->versi,
                    'foto' => $request->foto,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Item updated successfully', 
                    'data' => $perangkat
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
            return response()->json([
                'success' => true,
                'perangkat' => Perangkat::with('user')->get()
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
            $perangkat = Perangkat::where('id_user', $id)->get();

            return response()->json([
                'perangkat' => $perangkat
            ], 200);

            // $perangkatExistsInKebun = Kebun::all();

            // if ($perangkatExistsInKebun) {
            //     return response()->json([
            //         'message' => 'Perangkat is associated with a Kebun'
            //     ], 200);
            // } else {
            //     $perangkat = Perangkat::where('id_user', $id)->get();
                
            //     return response()->json([
            //         'perangkat' => $perangkat
            //     ], 200);
            // }
        }
    }

    function showidAlat(Request $request, $id){
        $user = User::where([
            'login_token' => $request->token
        ])->first();

        if ($request->token === null || !$user) {
            return response()->json([
                'message' => 'Unauthorisation User'
            ], 401);
        }else{

            $perangkat = Perangkat::with('user')->where('id', $id)->first();
            
            return response()->json([
                'perangkat' => $perangkat
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
            $kebun = Perangkat::find($id);

            $kebun->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kebun berhasil di hapus'
            ], 200);
        }
    }
}
