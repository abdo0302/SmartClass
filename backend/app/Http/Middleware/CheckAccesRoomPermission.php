<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Sinscrit;
use App\Models\Classe as Session;
use Illuminate\Support\Facades\Auth;

class CheckAccesRoomPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user=Auth::user();
        $id_class=$request->id;
        if ($user->hasRole('admin')) {
            return $next($request);
        } elseif ($user->hasRole('professeur')) {
            $Classe=Session::find($id_class);
            if ($Classe->in_user==$user->id) {
                return $next($request);
            }else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } elseif($user->hasRole('eleve')) {
            $Sinscrit=Sinscrit::where('in_classe', $id_class)->where('in_eleve', $user->id)->first();
            if ($Sinscrit) {
                return $next($request);
            }else{
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
    }
}
