<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\MatchController;
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

Route::get('/matchenum', [TypeEnumController::class, 'getenums']);

Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/match', [MatchController::class, 'index']);
Route::post('/match/filtre-recherche', [MatchController::class, 'filtreRecherche']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    //auth
    Route::get('/check-token', [AuthController::class, 'verifierToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    //match
    Route::controller(MatchController::class)->group(function () {
        //CRUD
        Route::post('/match', 'store');
        //NO-CRUD
    });
    

    Route::controller(ClubController::class)->group(function () {
        //CRUD
        Route::get('/club', 'index');
        Route::post('/club', 'store');
        Route::get('/club/modifier/{id}','edit');
        Route::put('/club/modifier/{id}','update');
        Route::delete('/club/suprimer/{id}','destroy');
        //NO-CRUD
        //invitation
        Route::get('/club/invitation/{invCode}', 'gererInvitation');
        Route::get('/club/invitation', 'afficheInvitations');
        Route::post('/club/invitation','accepteInvitations');
        //admin methods
        Route::delete('/club/exclure/{exclureId}', 'exclureMembre');
        Route::post('/club/changeroles', 'changerole');
        Route::get('/club/regenerercode','regenererCode');
        //ECT
        Route::delete('/club/exit','exitClub');
    });
});
