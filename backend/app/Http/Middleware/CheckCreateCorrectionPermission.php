<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Devoir;

class CheckCreateCorrectionPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer le devoir correspondant à l'id_devoir fourni dans la requête
        $devoir=Devoir::where('id', $request->id_devoir)->first();
        // Vérifier si le devoir existe
        if ($devoir) {

            // Récupérer l'ID de l'utilisateur qui a créé le devoir
            $id_creature_devoir=$devoir->in_creature;
            // Récupérer l'utilisateur actuellement authentifié
            $user=Auth::user();
            // Vérifier si l'utilisateur est celui qui a créé le devoir ou s'il a le rôle 'admin'
            if ($id_creature_devoir==$user->id || Auth::user()->hasRole('admin')) {
                // Si l'utilisateur est autorisé, passer la requête au middleware suivant
            return $next($request);
            }
        }
          
        // Si l'utilisateur n'est pas autorisé, retourner un message d'erreur
        return response()->json(['message' => 'Non autorise']);
        
    }
}
