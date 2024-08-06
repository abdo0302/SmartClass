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
        $id=$request->id;
        $id_user=Auth::user()->id;
        $Contenu = Contenu::where('id', $id)->first();
        $id_class=$Contenu->in_classe;
        $Sinscrit=Sinscrit::where('in_classe', $id_class)->where('in_eleve', $id_user)->first();
        if ($Sinscrit) {
            return $next($request);
        }else {
            return response()->json(['message' => 'Non autorisé']);
        }
        
        
    }
}
