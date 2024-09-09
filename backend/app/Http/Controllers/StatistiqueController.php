<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Classe;
use App\Models\Contenu;
use App\Models\Sinscrit;
use App\Models\Devoir;

class StatistiqueController extends Controller
{
    public function Statistique(){
        $user = Auth::user();
        if ($user->hasRole('admin')) {
         $total_users=User::count();
         $total_classes=Classe::count();
         $total_contenu=Contenu::count();
         $total_eleve=Sinscrit::count();
         $total_devoir=Devoir::count();
         return response()->json([$total_users, $total_classes, $total_contenu, $total_eleve, $total_devoir,], 200);
        }else{
            // Retourner un message d'erreur 
            return response()->json(['message' => 'Non autorisé'], 403);
        }
    }
}
