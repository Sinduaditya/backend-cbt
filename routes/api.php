<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UjianController;
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

// register
Route::post('/register', [AuthController::class,'register']);

// login
Route::post('/login', [AuthController::class,'login']);

// logout perlu menggunakan auth:scantum karna user sudah berada di dalam auth:scantum ini
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

// create ujian
Route::post('/create-ujian',[UjianController::class,'createUjian'])->middleware('auth:sanctum');

// get soal ujian
Route::get('/get-soal-ujian',[UjianController::class,'getListByKategori'])->middleware('auth:sanctum');

// post jawaban
Route::post('/answers',[UjianController::class,'jawabanSoal'])->middleware('auth:sanctum');
