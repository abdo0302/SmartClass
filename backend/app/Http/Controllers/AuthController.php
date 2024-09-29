<?php
/**
 * Class AuthController
 *
 * Description of what this class does.
 *
 * @package YourPackage
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomEmail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {    
        // Préparer les données pour l'email de bienvenue
        $data=[
            "name"=>$request->name,
            "role"=>$request->role
        ];
        // Verifiez que les donnees de la requête sont correctes
        $validateData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:eleve,professeur',
        ]);
        $token = Str::random(80);
        // Creer un utilisateur
         $user = User::create([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'password' => bcrypt($validateData['password']),
            'token'=>bcrypt($token)
         ]);

         // Attribuer le role en fonction de la valeur dans la demande
        if ($request->role=="eleve") {           
            $user->assignRole('eleve');
        } elseif ($request->role=="professeur") {
            $user->assignRole('professeur'); 
        }

        // Générer un jeton d'authentification pour l'utilisateur
        $token = auth('api')->login($user);
        // Envoyer un email de bienvenue à l'utilisateur
        Mail::to($validateData['email'])->send(new WelcomEmail($data));

        // Retourner la réponse avec le jeton d'authentification
        return $this->respondWithToken($token);
    }
    public function login(Request $request)
    {
         // Récupérer les identifiants (email et mot de passe) depuis la requête
        $credentials = $request->only('email', 'password');

        // Vérifier les identifiants et obtenir un token JWT
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Si l'authentification réussit, retourner une réponse avec le token JWT
        return $this->respondWithToken($token);
    }

    public function me()
    {
        // Retourner les informations de l'utilisateur en format JSON
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        // Déconnecter l'utilisateur
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        // Rafraîchir le token JWT et obtenir le nouveau token
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            // Le token JWT généré ou rafraîchi
            'access_token' => $token,
            // Le type de token
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function getPermissionsAndRoles()
    {
        // Get the currently authenticated user using the 'api' guard
        $user = auth('api')->user();

        // Return the roles and permissions of the user in a JSON response
        return response()->json([
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }
}
