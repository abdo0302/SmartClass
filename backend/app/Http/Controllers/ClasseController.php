<?php

namespace App\Http\Controllers;

use App\Models\Classe as Session;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Services\DailyService;
use Illuminate\Support\Str;
use App\Models\Sinscrit;

class ClasseController extends Controller
{
    
    public function create(Request $request)
    {   
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les Sessions
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
            // Valider les données reçues
            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:15|unique:classes',
            ]);

            // Ajouter l'id de l'utilisateur aux données validées
            $validatedData['in_user'] = $user->id;

            // Créer la Session après validation
            $Session = Session::create($validatedData);
            if ($Session) {
                // Instancier DailyService directement dans la méthode
                $dailyService = new DailyService();
                $room = Room::create([
                    'name'=>$request->input('name').Str::random(6),
                    'id_class'=>$Session->id,
                ]);
                $room_daily = $dailyService->createRoom($room->name);
                
                // Retourner une réponse JSON indiquant que la Session a été créée avec succès
                return response()->json(['message' => 'Classe creee avec succes'], 201);
            } else {
                // Retourner une réponse JSON indiquant un échec de la création de la Session
                return response()->json(['message' => 'Name de classe déjà existé'], 500);
            }
    }

    public function showAll()
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les Sessions
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
            // Récupérer l'identifiant de l'utilisateur authentifié
        $id_user=$user->id;

        if ($user->hasRole('admin')) {
            $Sessions=Session::all();
        }else{
            $Sessions=Session::where('in_user', $id_user)->get();
        }
        $inscriptions = [];

        // Parcourir chaque Session et récupérer les inscriptions correspondantes
        foreach ($Sessions as $Session) {
            $classInscriptions = Sinscrit::where('in_classe', $Session->id)->get();
            array_push($inscriptions,count($classInscriptions));
        }
        // Vérifier si des Sessions ont été trouvées
        if (count($Sessions)==0) {
            return response()->json('Aucun',200);
        }
        if ($Sessions) {
            return response()->json([
                'Classes'=>$Sessions,
                'eleve'=>$inscriptions],200);
        }else{
            return response()->json(['message' => 'Aucune Session trouvée'], 404);
        }
    }

    public function show(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les Sessions
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
           // Trouver la Session par son identifiant
          $id=$request->id;
          $Session=Session::find($id);
           // Vérifier si la Session a été trouvée
          if ($Session) {
            return response()->json($Session,200);
          }else{
            return response()->json(['message' => 'Session non trouvée'], 404);
          }
    }

    public function destroy(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les Sessions
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
          // Trouver la Session par son identifiant
          $id=$request->id;
          $Session=Session::findOrFail($id); 
          if ($Session) {
            $Room=Room::where('id_class', $request->id)->first();
            $Room->delete();
            $dailyService = new DailyService();
            $result = $dailyService->deleteRoom($Room->name);
            // Supprimer la Session trouvée
            $Session->delete();
            return response()->json(['message' => 'Session supprimée avec succès'], 200);
          }
          
    }

    public function update(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les classes
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
          // Trouver la classe par son identifiant
          $id=$request->id;
          $Classe=Session::findOrFail($id); 

            // Valider les données de la requête
          $validatedData = $request->validate([
            'name' => 'nullable|string|unique:classes',
            'date_creation' => 'nullable|date',
        ]);

        // Mettre à jour les informations de la classe
        $Classe->update($validatedData);

          // Retourner une réponse JSON avec un message de succès et le code de statut HTTP 200 (OK)
          return response()->json(['message' => 'Classe mise à jour avec succès'], 200);
    }

    //get eleve par Session
    public function getElevs($id){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les Sessions
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        // Récupérer les élèves inscrits dans Session   
        $elevs=[];
        $eleves_id=Sinscrit::where('in_classe', $id)->get('in_eleve');

        // Obtenir les informations de chaque élève
        foreach($eleves_id as $eleve_id){
            $elevsInfo=User::where('id', $eleve_id->in_eleve)->first();
            $elevs[$eleve_id->in_eleve]=$elevsInfo;
        }

        // Retourner les élèves ou 'Aucun' s'il n'y en a pas
        if (count($elevs)==0) {
            return response()->json('Aucun', 200);
        }
        return $elevs;
    }
    

}
