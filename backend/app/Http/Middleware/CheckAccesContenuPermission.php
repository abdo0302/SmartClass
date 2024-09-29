<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Sinscrit;

class CheckAccesContenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'ID de la classe depuis la requête
        $id=$request->id;
         // Récupérer l'utilisateur actuellement authentifié
        $user=Auth::user();

        // Vérifier si l'utilisateur est inscrit dans la classe correspondante
        $Sinscrit = Sinscrit::where('in_classe', $id)->where('in_eleve', $user->id)->first();
        // Si l'utilisateur est inscrit ou s'il a le rôle 'admin'
        if($Sinscrit || Auth::user()->hasRole('admin')){
            // Passer la requête au middleware suivant
            return $next($request);
        }else {
            // Si l'utilisateur n'est pas autorisé, retourner un message d'erreur
            return response()->json(['message' => 'Non autorisé']);
        }
        
    }
}
