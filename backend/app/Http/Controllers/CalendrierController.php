<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendrier;
use App\Models\Classe as Session;
use Illuminate\Support\Facades\Auth;

class CalendrierController extends Controller
{
    // Méthode pour créer un événement dans le calendrier
    public function create(Request $request){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Valider les données envoyées dans la requête
        $validatedData = $request->validate([
            'title' => 'required',
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'required|date_format:Y-m-d\TH:i|after:start',
            'id__session'=>'required|integer',
            'backgroundColor'=>'required|string'
        ]);

        // Ajouter l'identifiant de l'utilisateur qui crée l'événement
        $validatedData['in_creature'] = $user->id;

        // Créer un nouvel événement dans le calendrier
        $Calendrier = Calendrier::create($validatedData);

        // Vérifier si la création a réussi
        if ($Calendrier) {
            return response()->json(['message' => 'event creee avec succes'], 201);
        }else{
            return response()->json(['message' => 'Echec de la creation du event'], 500);
        }

    }

    // Méthode pour afficher tous les événements d'une session
    public function showAll($id){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Récupérer tous les événements liés à la session avec un identifiant donné
         $Calendrier=Calendrier::where('id__session', $id)->get(['title','start','end','backgroundColor']); 

         // Si des événements sont trouvés
        if ($Calendrier) {
            // Si aucun événement n'est trouvé
            if (count($Calendrier)==0) {
                return response()->json('Aucun',200);
            }

            // Retourner les événements trouvés
            return response()->json($Calendrier,200);
        }else{
            return response()->json(['message' => 'Aucune events trouvée'], 404);
        }

    }

    // Méthode pour supprimer un événement du calendrier
    public function destroy($title){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les classes

           $Calendrier=Calendrier::where('title',$title)->first();
           // Si l'événement est trouvé, le supprimer
           if ($Calendrier) {
              $Calendrier->delete();
           } 
    }
}
