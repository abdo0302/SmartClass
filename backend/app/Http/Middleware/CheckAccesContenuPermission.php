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
        $id=$request->id;
        $user=Auth::user();
        $Sinscrit = Sinscrit::where('in_classe', $id)->where('in_eleve', $user->id)->first();
        if($Sinscrit || Auth::user()->hasRole('admin')){
            return $next($request);
        }else {
            return response()->json(['message' => 'Non autorisé']);
        }
        
    }
}
