<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Devoir;
use App\Models\Sinscrit;

class CheckShowCorrectionDevoirPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user=Auth::user();

        // Vérifier si l'utilisateur a le rôle 'eleve'
        if ($user->hasRole('eleve')) {
            // Récupérer l'ID du devoir depuis la requête
            $id_devoir=$request->id;

            // Récupérer le devoir correspondant à l'ID fourni dans la requête
            $devoir=Devoir::where('id', $id_devoir)->first();

            // Vérifier si le devoir existe
            if ($devoir) {
                // Récupérer l'ID de la classe associée au devoir
                $id_class=$devoir->in_classe;

                // Vérifier si l'élève est inscrit dans la classe
                $Sinscrit=Sinscrit::where('in_eleve', $user->id)->where('in_classe', $id_class)->first();
                
                // Si l'élève est inscrit dans la classe
                if ($Sinscrit) {
                    // Passer la requête au middleware suivant
                    return $next($request);
                }else{
                     // Si l'élève n'est pas inscrit dans la classe, retourner un message d'erreur
                    return response()->json(['message' => 'Vous n\'êtes pas inscrit dans cette classe']);
                }
            }
        }
         // Si l'utilisateur n'est pas un élève, passer la requête au middleware suivant
        return $next($request);
    }
}
