<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\Classe as Session;
use App\Models\Sinscrit;
use App\Models\User;
use App\Services\AblyNotificationService;

class AccesSessionLiveController extends Controller
{
    // Propriété pour le service de notification
    protected $ablyNotificationService;

    // Constructeur pour injecter le service de notification
    public function __construct(AblyNotificationService $ablyNotificationService)
    {
        $this->ablyNotificationService = $ablyNotificationService;
    }

    // Méthode pour afficher les informations sur la session live
    public function show(Request $request)
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Vérifie si l'utilisateur a la permission d'accéder aux sessions live
        if (!$user->hasPermissionTo('acces au session live', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        // Cherche la salle (Room) liée à la classe demandée   
        $Room=Room::where('id_class', $request->id)->first();  


        if ($Room) {
            // Récupère la classe liée à la demande
            $Session=Session::where('id', $request->id)->first();
            
            // Vérifie si l'utilisateur est bien celui associé à la session
            if ($Session->in_user==$user->id) {          
                    // Récupère les élèves inscrits à la classe
                    $Sinscrits=Sinscrit::where('in_classe', $request->id)->get();
                    
                    // Pour chaque élève inscrit, envoie une notification
                    foreach ($Sinscrits as $sinscrit) {
                        $eleve=User::where('id', $sinscrit->in_eleve)->get();
                        
                        // Crée le message de notification
                        $message = 'La conférence a commencé dans la Session '.$Session->name;
                        
                        // Envoie la notification via le service Ably
                        $this->ablyNotificationService->sendNotification($eleve[0]->token, $message);
                    }
            }
            
             // Retourne le nom de la salle si elle existe
            return response()->json($Room->name, 200);
        }
    }
}
