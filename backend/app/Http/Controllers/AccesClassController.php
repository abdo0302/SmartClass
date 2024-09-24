<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Classe as Session;
use App\Models\Sinscrit;

class AccesClassController extends Controller
{
    // Affiche toutes les classes de eleve
    public function showAll()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();
        $id=$user->id;  //// ID de l'utilisateur
        

        // Si l'utilisateur est un élève
        if ($user->hasRole('eleve')) {

            // Tableau des classes
            $Sessions=[];

            // Récupère les inscriptions de l'élève
            $sinscrits = Sinscrit::where('in_eleve', $id)->get();
            // Pour chaque inscription, récupère la classe
            foreach ($sinscrits as $sinscrit) {
                $Session=Session::findOrFail($sinscrit->in_classe);
                // Ajoute la classe au tableau
                array_push($Sessions,$Session);
            }
            // Si l'élève n'a aucune classe
            if (count($Sessions)==0) {
                return response()->json('Aucun', 201);
            }
            // Retourne les classes
            return response()->json(['Classes'=>$Sessions], 201);
        }
    }
}
