<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(StoreUserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'nom' => strtolower($request->nom),
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'n_telephone' => $request->n_telephone,
            'code_postal' => $request->code_postal,
            'ville' => $request->ville,
            'region' => $request->region,
            'adresse' => $request->adresse,
            'niveau' => $request->niveau,
            'categorie' => $request->categorie,
            'league' => $request->league,
        ]);

        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        if (!Auth::attempt($request->only('email','password'))) {
            return response([
                "errors" => [
                    "email" => ["L'e-mail ou le mot de passe fourni est incorrect"]
                ]
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'),201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response('', 204);
    }
}
