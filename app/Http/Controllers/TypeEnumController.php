<?php

namespace App\Http\Controllers;

use App\Models\TypeEnum;
use Illuminate\Http\Request;

class TypeEnumController extends Controller
{
    public function getenums()
    {
        function getEnumdetail($selectedEnum)
        {
            $enum = TypeEnum::where('code', $selectedEnum)->first();
            return $enum->TypeEnumsDetails()->select('libelle as label', 'code as value')->get();
        }

        return [
            "categories" => getEnumdetail("cat"),
            "niveaus" => getEnumdetail("niv"),
            "regions" => getEnumdetail("reg"),
            "leagues" => getEnumdetail("lg")
        ];
    }
}
