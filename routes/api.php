<?php

use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\InfoController;
use App\Http\Controllers\API\KebunController;
use App\Http\Controllers\API\LogActivityController;
use App\Http\Controllers\API\MqttController;
use App\Http\Controllers\API\PerangkatController;
use App\Http\Controllers\API\PetaniController;
use App\Http\Controllers\API\TanamanController;
use App\Http\Controllers\API\UserController;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/detailregist/{id}', [UserController::class, 'updateRegist']);
Route::post('/auth/login', [UserController::class, 'login']);
Route::post('/auth/logout', [UserController::class, 'logout']);
Route::get('/auth/show', [UserController::class, 'show']);
Route::get('/auth/show/{id}', [UserController::class, 'showid']);
Route::get('/auth/hapus/{id}', [UserController::class, 'hapus']);
Route::post('/auth/update/{id}', [UserController::class, 'update']);

Route::get('/user', [PetaniController::class, 'showall']);
Route::get('/petani/show/{id}', [PetaniController::class, 'showid']);
Route::get('/user/admin', [PetaniController::class, 'showadmin']);
Route::get('/user/member', [PetaniController::class, 'showmember']);

//Informasi
Route::post('/info/tambah', [InfoController::class, 'tambah']);
Route::get('/info/show', [InfoController::class, 'show']);
Route::get('/info/show/{id}', [InfoController::class, 'showid']);
Route::post('/info/edit/{id}', [InfoController::class, 'edit']);
Route::get('/info/hapus/{id}', [InfoController::class, 'hapus']);

//Perangkat
Route::post('/perangkat/tambah', [PerangkatController::class, 'tambah']);
Route::get('/perangkat/show', [PerangkatController::class, 'show']);
Route::get('/perangkat/show/{id}', [PerangkatController::class, 'showid']);
Route::get('/perangkat/showidalat/{id}', [PerangkatController::class, 'showidAlat']);
Route::post('/perangkat/edit/{id}', [PerangkatController::class, 'edit']);
Route::get('/perangkat/hapus/{id}', [PerangkatController::class, 'hapus']);

//Tanaman
Route::post('/tanaman/tambah', [TanamanController::class, 'tambah']);
Route::get('/tanaman/show', [TanamanController::class, 'show']);
Route::get('/tanaman/foto', [TanamanController::class, 'foto']);
Route::get('/tanaman/showid/{id}', [TanamanController::class, 'showid']);
Route::post('/tanaman/edit/{id}', [TanamanController::class, 'edit']);
Route::get('/tanaman/hapus/{id}', [TanamanController::class, 'hapus']);

//Kebun
Route::post('/kebun/tambah', [KebunController::class, 'tambah']);
Route::get('/kebun/show', [KebunController::class, 'show']);
Route::get('/kebun/show/{id}', [KebunController::class, 'showid']);
Route::get('/kebun/showidkebun/{id}', [KebunController::class, 'showidkebun']);
Route::post('/kebun/edit/{id}', [KebunController::class, 'edit']);
Route::get('/kebun/hapus/{id}', [KebunController::class, 'hapus']);

//Mqtt
Route::get('/mqtt', [MqttController::class, 'getData']);
Route::get('/mqtt/{requestId}', [MqttController::class, 'getIdData']);
Route::post('/controlPump', [MqttController::class, 'controlPump']);
Route::post('/controlmotor1/{requestId}/{motor1}', [MqttController::class, 'ControlMotor1']);
Route::post('/controlmotor2/{requestId}/{motor2}', [MqttController::class, 'ControlMotor2']);

//Dashboard
Route::get('/count', [DashboardController::class, 'count']);
Route::get('/markers', [DashboardController::class, 'marker']);

Route::post('/logLogin/{userId}', [LogActivityController::class, 'logLogin']);
Route::post('/logLogout/{userId}', [LogActivityController::class, 'logLogout']);
Route::get('/logShow', [LogActivityController::class, 'logShow']);



