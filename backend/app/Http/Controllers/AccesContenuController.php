<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Contenu;
use App\Models\Voir;

class AccesContenuController extends Controller
{
    public function showAll(Request $request){
        // get les contenu par class

        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        
         // Vérifie si l'utilisateur a le rôle 'eleve'
        if ($user->hasRole('eleve')) {
            $Contenus = Contenu::where('in_classe', $request->id)->paginate(10);  
            // Retourner une réponse JSON
        return response()->json([$Contenus], 201);  
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
             // Récupérer le contenu correspondant à l'ID spécifié dans la requête
            $Contenus = Contenu::where('id', $request->id)->first(); 

            // Créer une nouvelle entrée dans la table 'Voir' pour enregistrer la visualisation du contenu
            $voir = Voir::create([
                'in_user'=>$user->id,
                'in_contenu'=>$request->id
                ]
            );

             // Si l'enregistrement de la visualisation a réussi, retourner le contenu au format JSON avec un code de réponse HTTP 201 (Créé)
            if ($voir) {
                return response()->json([$Contenus], 201);  
            } 
        }else {
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Non autorisé'], 403);
        }

    }
}
