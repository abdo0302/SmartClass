<?php

namespace App\Http\Controllers;

use App\Models\Sinscrit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InsctireClasseEmail;
use App\Models\User;
use App\Models\Notification;
use App\Models\Classe as Session;
use App\Services\AblyNotificationService;

class SinscritController extends Controller
{
    protected $ablyNotificationService;

    public function __construct(AblyNotificationService $ablyNotificationService)
    {
        $this->ablyNotificationService = $ablyNotificationService;
    }


    public function create(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        
         // Vérifie si l'utilisateur a la permission d'inscrire des élèves dans des classes
        if (!$user->hasPermissionTo('inscrire les élève dans class', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           }
        
        $exists =Sinscrit::where('in_eleve', $request->in_eleve)
                       ->where('in_classe', $request->in_classe)
                       ->first();
       
       if ($exists) {
           return response()->json(['Cet élève est déjà inscrit dans ce class.'], 403);
       }

          // Valide les données de la requête  
        $validatedData = $request->validate([
            'in_eleve' => 'required|integer',
            'in_classe' => 'required|integer',
        ]);   

        // Récupère les ID de l'élève et de la classe depuis la requête
        $id_eleve=$request->in_eleve;
        $id_classe=$request->in_classe;

        // Trouve l'élève et la classe correspondant aux ID fournis
        $eleve=User::findOrFail($id_eleve);
        $classe=Session::findOrFail($id_classe);

        // Prépare les données pour l'email
        $data=[
            "nameProfesseur"=>$user->name,
            "nameEleve"=>$eleve->name,
            "mameClass"=>$classe->name
        ];

        // Crée une nouvelle inscription (Sinscrit) avec les données validées
        $sinscrit = Sinscrit::create($validatedData);
        if ($sinscrit) {
            // Envoie un email à l'élève pour confirmer l'inscription
            Mail::to($eleve->email)->send(new InsctireClasseEmail($data));
            $message = 'Vous êtes inscrit dans la class '.$classe->name;
            $this->ablyNotificationService->sendNotification($eleve->token, $message);
            Notification::create([
                'title'=>$message,
                'user'=>$eleve->id
            ]);
            // Renvoie une réponse JSON
            return response()->json(['message' => 'sinscrit avec succès'], 201);
        } else {
            // Renvoie une réponse JSON avec un message
            return response()->json(['message' => 'eleve déjà inscri a class'], 500);
        }
    }

    public function show(Request $request)
    {
         // Récupérer l'utilisateur actuellement authentifié
         $user = Auth::user();
         
         // Vérifie si l'utilisateur a la permission d'inscrire des élèves dans des classes
         if (!$user->hasPermissionTo('inscrire les élève dans class', 'web')) {
             return response()->json(['message' => 'Non autorisé'], 403);
            }

            // Récupère l'ID de la classe depuis la requête
          $id=$request->id;

           // Récupère les inscriptions pour la classe spécifiée et les pagine par 10
          $Sinscrit=Sinscrit::where('in_classe', $id)->paginate(10);

         if ($Sinscrit) {
            // Renvoie les inscriptions au format JSON avec le code de statut HTTP 200 (OK)
             return response()->json([$Sinscrit],200);
         }else{
            // Renvoie une réponse JSON avec un message d'erreur et le code de statut HTTP 404 (Non trouvé)
             return response()->json(['message' => 'Aucune Sinscrit trouvée'], 404);
         }
    }

    public function destroy(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
        
        // Vérifie si l'utilisateur a la permission d'inscrire des élèves dans des classes
        if (!$user->hasPermissionTo('inscrire les élève dans class', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
           
           // Récupère l'ID de l'inscription à supprimer depuis la requête
        $id=$request->id;

         // Trouve l'inscription correspondant à l'ID fourni
        $Sinscrit = Sinscrit::where('in_eleve',$id)->first();

        if ($Sinscrit) {
            // Supprime l'inscription
            $Sinscrit->delete();
             // Renvoie une réponse JSON avec un message de succès
            return response()->json(['message' => 'Sinscrit supprimée avec succès'], 200);
        }
        // Renvoie une réponse JSON avec un message d'erreur
        return response()->json(['message' => 'Sinscrit non trouvé'], 404);
    }

    //rechercher eleve
    public function rocherch($email){
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Vérifie si l'utilisateur a la permission d'inscrire les élèves dans une Session
        if (!$user->hasPermissionTo('inscrire les élève dans class', 'web')) {
            // Renvoie un message d'erreur si l'utilisateur n'est pas autorisé
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        // Recherche les élèves dont l'email correspond au critère (partiel ou total)   
         $eleve=User::where('email','like', '%'.$email . '%')->get();
         // Renvoie les résultats de la recherche en format JSON avec un code de statut 201
         return response()->json($eleve, 201);
    }
}
