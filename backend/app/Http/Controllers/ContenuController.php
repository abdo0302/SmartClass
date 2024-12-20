<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Classe as Session;
use App\Models\Sinscrit;
use App\Mail\RappelContenulEmail;
use App\Models\Voir;
use Illuminate\Support\Facades\Mail;
use App\Services\AblyNotificationService;
use App\Models\Notification;

class ContenuController extends Controller
{
    protected $ablyNotificationService;

    public function __construct(AblyNotificationService $ablyNotificationService)
    {
        $this->ablyNotificationService = $ablyNotificationService;
    }

    public function create(Request $request)
    {
        // Vérifie si l'utilisateur actuel a la permission nécessaire
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les contenus', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        // Validation des données reçues du formulaire   
        $validatedData = $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,pdf,docx,mp4|max:2048',
            'in_classe' => 'required|integer',
        ]);   

        // Traitement du fichier uploadé s'il y en a un
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file'), $fileName);
            $validateDta['file'] = 'file/' . $fileName;

            // Get the MIME type of the file
            $mimeType = $file->getClientMimeType();
            $validatedData['file'] = 'file/' . $fileName;
            $validatedData['typ_file'] = $mimeType;
        }
        
        $validatedData['in_creature'] = $user->id;

        $data=[
            "name"=>$user->name,
        ];
        
        // Enregistrement du contenu dans la base de données
        $contenu = Contenu::create($validatedData);

        if ($contenu) {
            $Sinscrits=Sinscrit::where('in_classe', $request->in_classe)->get();
             // Envoi d'e-mails aux élèves inscrits à la Session concernée
            $email_eleves=[];
            foreach ($Sinscrits as $sinscrit) {
                $eleve=User::where('id', $sinscrit->in_eleve)->get();
                Mail::to($eleve[0]->email)->send(new RappelContenulEmail($data));

                $message = 'Un Contenu intitulé '.$validatedData['titre'].' a été ajouté';
                $this->ablyNotificationService->sendNotification($eleve[0]->token, $message);
                Notification::create([
                    'title'=>$message,
                    'user'=>$eleve[0]->id
                ]);
            }
            
            return response()->json(['message' => 'Contenu cree avec succes'], 201);
        } else {
            // Retourner un message d'erreur 
            return response()->json(['message' => 'error'], 500);
        }
    }

    public function showAll(Request $request)
    {
        // get all contenu par class

         // Vérifie si l'utilisateur actuel a la permission nécessaire
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les contenus', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        // Récupération de tous les contenus pour une classe spécifique   
        $Contenus=Contenu::where('in_classe', $request->id)->get();

        if (count($Contenus)==0) {
            return response()->json('Aucun', 200);
        }

        if ($Contenus) {
            return response()->json($Contenus, 200);
        }else{
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun contenu trouvé'], 404);
        }   
    }

    public function show(Request $request)
    {
        // get all contenu par id

        // Vérifie si l'utilisateur actuel a la permission nécessaire
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les contenus', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        // Récupération d'un contenu spécifique par son ID   
        if ($user->hasRole('admin')) {
            $Contenu=Contenu::where('id', $request->id)->first();
        }else{
           $Contenu=Contenu::where('id', $request->id)->where('in_creature', $user->id)->first();
        }   
        
        if ($Contenu) {
            return response()->json($Contenu, 200);
        }else{
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun contenu trouvé'], 404);
        }
    }

    public function update(Request $request)
    {
        // Vérifie si l'utilisateur actuel a la permission nécessaire
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les contenus', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        // Validation des données reçues du formulaire   
        $validatedData = $request->validate([
            'titre' => 'nullable|string',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,pdf,docx,mp4|max:2048',
            'date_creation' => 'nullable|date',
            'in_classe' => 'nullable|integer',
        ]);   

        // Traitement du fichier uploadé s'il y en a un
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file'), $fileName);
            $validateDta['file'] = 'file/' . $fileName;

            // Get the MIME type of the file
            $mimeType = $file->getClientMimeType();
            $validatedData['file'] = 'file/' . $fileName;
            $validatedData['typ_file'] = $mimeType;
        }

        // Vérification des permissions de mise à jour basée sur le rôle de l'utilisateur
        if ($user->hasRole('admin')) {
            $Contenu=Contenu::where('id', $request->id)->first();
        }else{
            $Contenu=Contenu::where('id', $request->id)->where('in_creature', $user->id)->first();
        }
        
        if ($Contenu) {
            // Mise à jour du contenu dans la base de données
            $Contenu->update($validatedData);
            return response()->json(['message' => 'Contenu modifié avec succès'], 200);
        } else {
            // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun contenu trouvé'], 404);
        }
    }

    public function get4Contenu(){
        $user = Auth::user();
    
        // Vérifie si l'utilisateur a la permission de gérer les contenus
        if (!$user->hasPermissionTo('gere les contenus', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

           // Récupère les contenus en fonction du rôle de l'utilisateur
        if ($user->hasRole('admin')) {
            $Contenu=Contenu::limit(4)->get();
        }else{
           $Contenu=Contenu::where('in_creature', $user->id)->limit(4)->get();
        }     

        if (count($Contenu)==0) {
            return response()->json('Aucun', 200);
        }
        if ($Contenu) {
            return response()->json($Contenu, 200);
        }else{
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun Contenu trouvé'], 404);
        }
    }

    // Méthode pour supprimer un contenu
    public function destroy(Request $request)
    {
         // Vérifie si l'utilisateur actuel a la permission nécessaire
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les contenus', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           } 

        // Vérification des permissions de suppression basée sur le rôle de l'utilisateur   
        if ($user->hasRole('admin')) {
            $Contenu=Contenu::where('id', $request->id)->first();
        }else{
            $Contenu=Contenu::where('id', $request->id)->where('in_creature', $user->id)->first();   
        }
        
        if ($Contenu) {
             // Suppression du contenu de la base de données
            $Contenu->delete();
            return response()->json(['message' => 'Classe supprimée avec succès'], 200);
        }else{
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun contenu trouvé'], 404);
        }
    }

    public function statistique($id){
        // Récupère l'utilisateur authentifié
        $user = Auth::user();

        // Vérifie si l'utilisateur a la permission de gérer les contenus
        if (!$user->hasPermissionTo('gere les contenus', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
        } 

        // Tableau pour stocker les informations des utilisateurs ayant vu le contenu
        $users=[];

        // Récupère les statistiques des vues du contenu spécifié
        $statistiques=Voir::where('in_contenu', $id)->get();
        // Vérifie si des statistiques existent
        if ($statistiques) {
            // Calcule le total des vues du contenu
            $total=count($statistiques);

            // Parcourt chaque statistique et récupère les informations de l'élève correspondant
            foreach($statistiques as $statistique){
                $eleve=User::where('id',$statistique->in_user)->first(['name','email']);
                // Ajoute les informations de l'élève au tableau des utilisateurs
                array_push($users,$eleve);
            }

            // Retourne les statistiques avec le nombre total et les informations des utilisateurs
            return response()->json([
                'total' => $total,
                'statistique'=>$users
            ], 200);
        }else{
            // Retourne une réponse indiquant qu'il n'y a aucune statistique si aucune vue n'est trouvée
            return response()->json(['total' => 0], 200);
        }
    }
}
