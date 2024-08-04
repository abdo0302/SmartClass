<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class CheckSinscriPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupère l'ID de la classe depuis la requête
        $id=$request->in_classe;

        // Trouve la classe correspondant à l'ID fourni
        $classe=Classe::find($id);

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
