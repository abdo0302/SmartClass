<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Configuration\Middleware;
use App\Models\Classe;

class CheckClassPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer l'identifiant de la classe depuis la requête
        $id=$request->id;
         // Rechercher la classe par son identifiant
        $Classe=Classe::find($id);
        if(!$Classe){
            return response()->json(['message' => 'NULL']);
        }
        // Vérifier si la classe appartient à l'utilisateur authentifié
        if ($Classe->in_user == Auth::user()->id || Auth::user()->hasRole('admin')) {
            // Si l'utilisateur est le propriétaire de la classe, continuer la requête
            return $next($request);
        }
        return response()->json(['message' => 'Non autorisé']);
        
    }
}
