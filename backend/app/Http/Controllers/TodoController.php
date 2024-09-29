<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // Méthode pour créer un nouveau Todo
    public function create(Request $request)
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Vérifie si l'utilisateur a la permission de gérer les todos
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           }

           // Valide les données envoyées dans la requête
           $validatedData = $request->validate([
            'title' => 'required|string',
            'priority'=>'in:urgen,Important,non urgent',
            'color'=>'required|string'
        ]);

        // Associe l'ID de l'utilisateur au Todo créé
        $validatedData['in_creature']=$user->id;

        // Crée un nouveau Todo avec les données validées
        $Todo = Todo::create($validatedData);

        // Vérifie si la création du Todo a réussi
            if ($Todo) {
                return response()->json(['message' => 'Not créée avec succes'], 201);
            } else {
                return response()->json(['message' => 'Echec de la creation du Not'], 500);
            }   
    }

    public function show(Request $request)
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();
    
        // Vérifie si l'utilisateur a la permission de gérer les todos
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           }

           // Si l'utilisateur a le rôle d'admin, il peut voir n'importe quel Todo
        if ($user->hasRole('admin')) {
            $Todo=Todo::where('id', $request->id)->first();
        }else{
            // Sinon, il ne peut voir que les Todos qu'il a créés
           $Todo=Todo::where('id', $request->id)->where('in_creature', $user->id)->first();
        }  
        // Vérifie si le Todo existe
        if ($Todo) {
            return response()->json(['Not' => $Todo], 200);
        }else{
            return response()->json(['message' => 'Aucun Not trouve'], 404);
        }
    }

    public function showAll(Request $request)
    {
         // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Vérifie si l'utilisateur a la permission de gérer les todos
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

           // Récupère tous les Todos créés par l'utilisateur
           $Todo=Todo::where('in_creature', $user->id)->get();

           // Vérifie s'il y a des Todos à afficher
        if (count($Todo)==0) {
            return response()->json('Aucun', 200);
        }  
           
        // Retourne la liste des Todos
        if ($Todo) {
            return response()->json($Todo, 200);
        }
    }

    public function destroy(Request $request)
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Vérifie si l'utilisateur a la permission de gérer les todos
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           } 
  
           // Récupère le Todo spécifié s'il a été créé par l'utilisateur
         $Todo=Todo::where('id', $request->id)->where('in_creature', $user->id)->first();   
        
         // Vérifie si le Todo existe
        if ($Todo) {
            // Supprime le Todo
            $Todo->delete();
            return response()->json(['message' => 'Todo supprimee avec succes'], 200);
        }else{
            return response()->json(['message' => 'Aucun Todo trouve'], 404);
        }
    }
}
