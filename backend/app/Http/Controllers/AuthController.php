<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomEmail;

class AuthController extends Controller
{
    public function register(Request $request)
    {    $data=[
            "name"=>$request->name,
            "role"=>$request->role
        ];
        // Verifiez que les donnees de la requête sont correctes
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:eleve,professeur',
        ]);
        
        // Creer un utilisateur
         $user = User::create([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'password' => bcrypt($validateData['password']),
         ]);

         // Attribuer le role en fonction de la valeur dans la demande
        if ($request->role=="eleve") {           
            $user->assignRole('eleve');
        } elseif ($request->role=="professeur") {
            $user->assignRole('professeur'); 
        }

        $token = auth('api')->login($user);
        Mail::to($validateData['email'])->send(new WelcomEmail($data));
        return $this->respondWithToken($token);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
