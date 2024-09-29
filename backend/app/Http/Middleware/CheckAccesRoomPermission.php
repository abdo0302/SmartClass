<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Sinscrit;
use App\Models\Classe as Session;
use Illuminate\Support\Facades\Auth;

class CheckAccesRoomPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupère l'utilisateur connecté
        $user=Auth::user();
         // Récupère l'identifiant de la classe depuis la requête
        $id_class=$request->id;

        // Si l'utilisateur est un admin, il peut accéder à tout
        if ($user->hasRole('admin')) {
            return $next($request);     
        } 
        // Si l'utilisateur est un professeur
        elseif ($user->hasRole('professeur')) {
            // Trouve la classe correspondant à l'identifiant
            $Classe=Session::find($id_class);
            // Vérifie si la classe appartient à ce professeur
            if ($Classe->in_user==$user->id) {
                return $next($request);
            }else {
                // Sinon return non autorisé
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Si l'utilisateur est un élève
        } elseif($user->hasRole('eleve')) {
            // Vérifie si l'élève est inscrit à la classe
            $Sinscrit=Sinscrit::where('in_classe', $id_class)->where('in_eleve', $user->id)->first();
            if ($Sinscrit) {
                // Si oui, il peut accéder
                return $next($request);
            }else{
                // Sinon, accès non autorisé
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            // Si l'utilisateur n'a aucun rôle spécifique
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
    }
}
