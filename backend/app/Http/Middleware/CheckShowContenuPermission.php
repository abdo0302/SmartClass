<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Contenu;
use App\Models\Sinscrit;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckShowContenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'ID du contenu depuis la requête
        $id=$request->id;

        // Récupérer l'ID de l'utilisateur actuellement authentifié
        $id_user=Auth::user()->id;

        // Récupérer le contenu correspondant à l'ID fourni dans la requête
        $Contenu = Contenu::where('id', $id)->first();

        // Vérifier si le contenu existe
        if ($Contenu) {
            // Récupérer l'ID de la classe associée au contenu
            $id_class=$Contenu->in_classe;
            // Vérifier si l'utilisateur est inscrit dans la classe
            $Sinscrit=Sinscrit::where('in_classe', $id_class)->where('in_eleve', $id_user)->first();
            
            // Si l'utilisateur est inscrit dans la classe
            if ($Sinscrit) {

                // Passer la requête au middleware suivant
                return $next($request);
            }else {
                // Si l'utilisateur n'est pas inscrit, retourner un message d'erreur
                return response()->json(['message' => 'Non autorisé']);
            }
        }
        
        return response()->json(['message' => 'Non autorisé']);
        
    }
}
