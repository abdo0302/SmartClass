<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devoir;
use App\Models\realise;
use Illuminate\Support\Facades\Auth;

class AccesDevoirController extends Controller
{
    public function showAll(Request $request){
        // get les Devoir par class

        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        
         // Vérifie si l'utilisateur a le rôle 'eleve'
        if ($user->hasRole('eleve')) {
            $Devoirs = Devoir::where('in_classe', $request->id)->paginate(10);  
            // Retourner une réponse JSON
        return response()->json([$Devoirs], 201);  
        }else {
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Non autorisé'], 403);
        }

    }

    public function show(Request $request){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

         // Vérifie si l'utilisateur a le rôle 'eleve'
        if ($user->hasRole('eleve')) {
             // Récupérer le Devoir correspondant à l'ID spécifié dans la requête
            $Devoir = Devoir::where('id', $request->id)->first(); 

            // Créer une nouvelle entrée dans la table 'realise' pour enregistrer la visualisation du Devoir
            $realise=realise::where('in_user', $user->id)->where('in_Devoir', $request->id)->first();
            if (!$realise) {
                $realise = realise::create([
                'in_user'=>$user->id,
                'in_Devoir'=>$request->id
                ]
            );
            }
            
                return response()->json([$Devoir], 201);  
        }else {
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Non autorisé'], 403);
        }

    }
}
