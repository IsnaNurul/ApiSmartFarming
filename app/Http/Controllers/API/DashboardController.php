<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Marker;
use App\Models\Perangkat;
use App\Models\Tanaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    function count(){
        $petani = User::where('role', 'member')->count();
        $perangkat = Perangkat::all()->count();
        $tanaman = Tanaman::all()->count();

        return response()->json([
            'petani' => $petani,
            'perangkat' => $perangkat,
            'tanaman' => $tanaman
        ]);

    }

    function marker() {
        $markers = Marker::all();

        return response()->json(([
            'markers' => $markers
        ]));
    }
}
