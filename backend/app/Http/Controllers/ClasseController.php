<?php

namespace App\Http\Controllers;

use App\Models\Classe;
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
        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les classes
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
            // Valider les données reçues
            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:15|unique:classes',
            ]);

            // Ajouter l'id de l'utilisateur aux données validées
            $validatedData['in_user'] = $user->id;

            // Créer la classe après validation
            $classe = Classe::create($validatedData);
            if ($classe) {
                // Instancier DailyService directement dans la méthode
                $dailyService = new DailyService();
                $room = Room::create([
                    'name'=>$request->input('name').Str::random(6),
                    'id_class'=>$classe->id,
                ]);
                $room_daily = $dailyService->createRoom($room->name);
                
                // Retourner une réponse JSON indiquant que la classe a été créée avec succès
                return response()->json(['message' => 'Classe creee avec succes'], 201);
            } else {
                // Retourner une réponse JSON indiquant un échec de la création de la classe
                return response()->json(['message' => 'Name de classe déjà existé'], 500);
            }
    }

    public function showAll()
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les classes
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
            // Récupérer l'identifiant de l'utilisateur authentifié
        $id_user=$user->id;

        if ($user->hasRole('admin')) {
            $Classes=Classe::all();
        }else{
            $Classes=Classe::where('in_user', $id_user)->get();
        }
        $inscriptions = [];

        // Parcourir chaque classe et récupérer les inscriptions correspondantes
        foreach ($Classes as $classe) {
            $classInscriptions = Sinscrit::where('in_classe', $classe->id)->get();
            array_push($inscriptions,count($classInscriptions));
        }
        // Vérifier si des classes ont été trouvées
        if (count($Classes)==0) {
            return response()->json('Aucun',200);
        }
        if ($Classes) {
            return response()->json([
                'Classes'=>$Classes,
                'eleve'=>$inscriptions],200);
        }else{
            return response()->json(['message' => 'Aucune classe trouvée'], 404);
        }
    }

    public function show(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les classes
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
           // Trouver la classe par son identifiant
          $id=$request->id;
          $Classe=Classe::find($id);
           // Vérifier si la classe a été trouvée
          if ($Classe) {
            return response()->json($Classe,200);
          }else{
            return response()->json(['message' => 'Classe non trouvée'], 404);
          }
    }

    public function destroy(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les classes
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
          // Trouver la classe par son identifiant
          $id=$request->id;
          $Classe=Classe::findOrFail($id); 
          if ($Classe) {
            $Room=Room::where('id_class', $request->id)->first();
            $Room->delete();
            $dailyService = new DailyService();
            $result = $dailyService->deleteRoom($Room->name);
            // Supprimer la classe trouvée
            $Classe->delete();
            return response()->json(['message' => 'Classe supprimée avec succès'], 200);
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
          $Classe=Classe::findOrFail($id); 

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

    //get eleve par class
    public function getElevs($id){
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission nécessaire pour gérer les classes
        if (!$user->hasPermissionTo('gerer class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
        $elevs=[];
        $eleves_id=Sinscrit::where('in_classe', $id)->get('in_eleve');
        foreach($eleves_id as $eleve_id){
            $elevsInfo=User::where('id', $eleve_id->in_eleve)->first();
            $elevs[$eleve_id->in_eleve]=$elevsInfo;
        }
        return $elevs;
    }

}
