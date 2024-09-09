<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendrier;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class CalendrierController extends Controller
{
    public function create(Request $request){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        $validatedData = $request->validate([
            'title' => 'required',
            'start' => 'required|date_format:Y-m-d',
            'end' => 'required|date_format:Y-m-d|after:start_time',
        ]);
        $validatedData['in_creature'] = $user->id;
        $Calendrier = Calendrier::create($validatedData);
        if ($Calendrier) {
            return response()->json(['message' => 'event creee avec succes'], 201);
        }else{
            return response()->json(['message' => 'Echec de la creation du event'], 500);
        }

    }

    public function showAll(){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
         $Calendrier=Calendrier::where('in_creature', $user->id)->get(['title','start','end']); 

        if ($Calendrier) {
            return response()->json($Calendrier,200);
        }else{
            return response()->json(['message' => 'Aucune events trouvée'], 404);
        }

    }

    public function destroy($title){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les classes

           $Calendrier=Calendrier::where('title', $title)->first();
           if ($Calendrier) {
              $Calendrier->delete();
           } 
    }
}
