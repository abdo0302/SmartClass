<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Sinscrit;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class CheckSinscriDeletPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupère l'ID de l'inscription depuis la requête
        $id=$request->id;

        // Trouve l'inscription (Sinscrit) correspondant à l'ID fourni
        $Sinscrit = Sinscrit::where('in_eleve',$id)->first();

         // Récupère l'ID de la classe associée à cette inscription
        $in_classe = $Sinscrit->in_classe;

         // Trouve la classe correspondant à l'ID de la classe
        $classe=Classe::find($in_classe);

        // Obtient l'utilisateur actuellement authentifié
        $user=Auth::user();

        // Vérifie si l'utilisateur est le propriétaire de la classe ou s'il a le rôle 'admin'
        if ($classe->in_user == $user->id || $user->hasRole('admin')){
            // Autorise l'accès et passe la requête au prochain middleware ou au contrôleur
            return $next($request);
        }
         // Renvoie une réponse JSON avec un message d'erreur
        return response()->json(['message' => 'Non autorisé']);
    }
}
