<?php

use App\Models\TypeEnum;
use App\Models\TypeEnumsDetail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/defaultdata', function () {
    TypeEnum::create([
        "libelle" => "categories"
    ]);
    return "done";
});

Route::get('/defaultdata2', function () {
    for ($i = 6; $i <= 20; $i++) {
        TypeEnumsDetail::insert([
            [
                "type_enum_id" => 1,
                "libelle" => "U$i"
            ], [
                "type_enum_id" => 1,
                "libelle" => "U$i Féminine"
            ]
        ]);
    }
    TypeEnumsDetail::insert([
        [
            "type_enum_id" => 1,
            "libelle" => "Seniors"
        ], [
            "type_enum_id" => 1,
            "libelle" => "Vétérans"
        ]
    ]);
    
    return "done";
});
