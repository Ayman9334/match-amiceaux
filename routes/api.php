<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\TableMatchController;
use App\Http\Controllers\TypeEnumController;
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
    return $request->user()->only('nom', 'logo', 'email');
});

Route::get('/match', [TableMatchController::class, 'index']);


Route::get('/matchenum', [TypeEnumController::class, 'getenums']);



Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/check-token', [AuthController::class, 'verifierToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/match/store', [TableMatchController::class, 'store']);

    Route::controller(ClubController::class)->group(function () {
        Route::get('/club', 'index');
        Route::post('/club', 'store');
        Route::get('/club/invitation', 'afficheInvitations');
        Route::post('/club/invitation/{invCode}', 'gererInvitation');
    });
});


Route::get('/user', [UserController::class, 'index']);
