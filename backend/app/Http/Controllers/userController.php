<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\DeleteAcunteEmail;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $id=$request->id;

        // Vérifier si l'utilisateur est un administrateur
        if ($user->hasRole('admin')) {
            // Récupérer l'utilisateur par son ID
            $User = User::findOrFail($id); 

        return response()->json(['User' => $User], 201);  
        }else {
            // Retourner un message d'erreur 
            return response()->json(['message' => 'Non autorisé'], 403);
        }
    }

    public function showAll(Request $request)
    {
        $user = Auth::user();
         // Vérifier si l'utilisateur est un administrateur
        if ($user->hasRole('admin')) {
            // Récupérer la liste paginée des utilisateurs
            $Users = User::get(); 

            // Retourner la liste des Users paginée
        return response()->json($Users, 201);  
        }else {
            // Retourner un message d'erreur 
            return response()->json(['message' => 'Non autorisé'], 403);
        }
    }

    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        // Récupérer l'utilisateur à mettre à jour
         $User = User::findOrFail($user_id);

         // Vérifier si l'utilisateur authentifié essaie de mettre à jour son propre compte
            
            // Valider les données de la requête
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users',
                'password' => 'nullable|string|min:8|confirmed',
            ]);
            // Crypter le mot de passe uniquement s'il est fourni
            $validatedData['password']=bcrypt($validatedData['password']);

            // Mettre à jour l'utilisateur avec les données validées
            $User->update($validatedData);
            // Retourner le User mis à jour
        return response()->json(['message' => 'Votre compte à jour avec succès'], 201);  
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $id=$request->id;

        // Vérifier si l'utilisateur est administrateur et qu'il ne tente pas de supprimer son propre compte
        if ($user->hasRole('admin') || $id !== $user->id) {
            $Users = User::findOrFail($id); 

            // Préparer les données pour l'email
            if ($Users) {
                if ($user->hasRole('admin')) {
                    $data=[
                    "name"=>$user->name,
                   ];

                    // Envoyer l'email à l'utilisateur à supprimer
                    Mail::to($Users->email)->send(new DeleteAcunteEmail($data));
                }
                

               // Supprimer l'utilisateur
               $Users->delete();
            }

        return response()->json(['message' => 'User supprimée avec succès'], 201);  
        }else {
            // Retourner un message d'erreur 
            return response()->json(['message' => 'Non autorisé'], 403);
        }
    }
}
