<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Devoir;
use App\Models\Sinscrit;

class CheckShowDevoirPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'ID du devoir depuis la requête
        $id=$request->id;

        // Récupérer l'ID de l'utilisateur actuellement authentifié
        $id_user=Auth::user()->id;

        // Récupérer le devoir correspondant à l'ID fourni dans la requête
        $Devoir = Devoir::where('id', $id)->first();
        if ($Devoir) {
            // Récupérer l'ID de la classe associée au devoir
            $id_class=$Devoir->in_classe;

            // Vérifier si l'utilisateur est inscrit dans la classe
            $Sinscrit=Sinscrit::where('in_classe', $id_class)->where('in_eleve', $id_user)->first();
            
             // Si l'utilisateur est inscrit dans la classe
            if ($Sinscrit) {
                // Passer la requête au middleware suivant
                return $next($request);
            }else {
                // Si l'utilisateur n'est pas inscrit dans la classe, retourner un message d'erreur
                return response()->json(['message' => 'Non autorise']);
            }
        }
        return response()->json(['message' => 'Devoir non trouvé'], 404);
    }
}
