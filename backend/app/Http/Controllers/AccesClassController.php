<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Classe;
use App\Models\Sinscrit;

class AccesClassController extends Controller
{
    public function showAll()
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        $id=$user->id;
        
         // Vérifie si l'utilisateur a le rôle 'eleve'
        if ($user->hasRole('eleve')) {

            // Initialise un tableau pour stocker les classes
            $classes=[];

            // Récupère toutes les inscriptions (Sinscrit) pour l'utilisateur authentifié
            $sinscrits = Sinscrit::where('in_eleve', $id)->get();
            // Parcourt chaque inscription pour trouver les classes associées
            
            foreach ($sinscrits as $sinscrit) {
                // Trouve la classe correspondant à l'ID dans l'inscription
                $classe=Classe::findOrFail($sinscrit->in_classe);

                 // Ajoute la classe au tableau des classes
                array_push($classes,$classe);
            }

            // Retourner une réponse JSON
            return response()->json([$classes], 201);
        }
    }
}
