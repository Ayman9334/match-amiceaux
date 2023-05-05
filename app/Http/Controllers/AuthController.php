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

        $newUser = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
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
        $token = $newUser->createToken('user_token')->plainTextToken;
        $response = [
            'user' => $newUser,
            'token' => $token
        ];
        return response($response,201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided email or password is incorrect'
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('user_token')->plainTextToken;

        return response(compact('user', 'token'),201);
    }

    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
