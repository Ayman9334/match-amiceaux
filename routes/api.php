<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableMatchController;
use App\Http\Controllers\UserController;
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

Route::get('/match', [TableMatchController::class,'index']);

Route::resource('/user', UserController::class);

Route::get('/matchenum', [UserController::class, "getenums"]);


Route::post('auth/signup', [AuthController::class, 'signup']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('auth/logout', [AuthController::class, "logout"]);
    Route::post('match/store', [TableMatchController::class, "store"]);
});
