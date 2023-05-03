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
        "libelle" => "categories",
        "code" => "cat",
    ]);
    return "done";
});

Route::get('/defaultdata2', function () {
    for ($i = 6; $i <= 20; $i++) {
        TypeEnumsDetail::create([
            "type_enum_id" => 1,
            "libelle" => "U$i Féminine",
            "code" => "u$i" . "fcat",
        ]);
        TypeEnumsDetail::create([
            "type_enum_id" => 1,
            "libelle" => "U$i",
            "code" => "u$i" . "cat",
        ]);
    }
    TypeEnumsDetail::create([
        "type_enum_id" => 1,
        "libelle" => "Seniors",
        "code" => "snrcat",
    ]);
    TypeEnumsDetail::create([
        "type_enum_id" => 1,
        "libelle" => "Vétérans",
        "code" => "vtrcat",
    ]);

    return "done";
});
