<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\TypeEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::first();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validated();

        $newUser = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'n_telephone' => $request->n_telephone,
            'code_postal' => $request->code_postal,
            'ville' => $request->ville,
            'region' => $request->region,
            '' => $request->,
            '' => $request->,
            '' => $request->,
            '' => $request->,
        ]);

        
        return '';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

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
