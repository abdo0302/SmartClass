<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Classe as Session;
use App\Models\Contenu;
use App\Models\Sinscrit;
use App\Models\Devoir;

class StatistiqueController extends Controller
{
    // Méthode pour récupérer les statistiques
    public function Statistique()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();
        // Vérifie si l'utilisateur a le rôle d'admin
        if ($user->hasRole('admin')) {
            // Compte le nombre total d'utilisateurs
         $total_users=User::count();
         // Compte le nombre total de Session
         $total_classes=Session::count();
         // Compte le nombre total de contenus
         $total_contenu=Contenu::count();
          // Compte le nombre total d'élèves inscrits
         $total_eleve=Sinscrit::count();
         // Compte le nombre total de devoirs
         $total_devoir=Devoir::count();
         return response()->json([$total_users, $total_classes, $total_contenu, $total_eleve, $total_devoir,], 200);
        }else{
            // Retourner un message d'erreur 
            return response()->json(['message' => 'Non autorisé'], 403);
        }
    }
}
