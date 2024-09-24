<?php

namespace App\Http\Controllers;

use App\Models\Devoir;
use App\Models\realise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AblyNotificationService;
use App\Models\Sinscrit;
use App\Models\User;
use App\Models\Notification;

class DevoirController extends Controller
{   protected $ablyNotificationService;

    public function __construct(AblyNotificationService $ablyNotificationService)
    {
        $this->ablyNotificationService = $ablyNotificationService;
    }
   
    public function create(Request $request)
    {
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission de gérer les devoirs
        if (!$user->hasPermissionTo('gerer les devoir', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

         // Valider les données du formulaire
           $validatedData = $request->validate([
            'titre' => 'required|string|unique:devoirs',
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

        // Ajouter l'identifiant de l'utilisateur créateur au tableau de données validées
        $validatedData['in_creature']=$user->id;

        // Créer le devoir
        $Devoir = Devoir::create($validatedData);

        // Vérifier si la création a réussi
            if ($Devoir) {

                $Sinscrit = Sinscrit::where('in_classe',$validatedData['in_classe'])->get('in_eleve');
                foreach($Sinscrit as $id_eleve){
                    $token_user=User::where('id',$id_eleve->in_eleve)->first();
                    $message = 'Un exercice intitulé '.$validatedData['titre'].' a été ajouté';
                    $this->ablyNotificationService->sendNotification($token_user->token, $message);
                    Notification::create([
                        'title'=>$message,
                        'user'=>$token_user->id
                    ]);
                }
                return response()->json(['message' => 'devoir créée avec succes'], 201);
            } else {
                // Retourner un message d'erreur 
                return response()->json(['message' => 'Échec de la création du devoir'], 500);
            }   
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission de gérer les devoirs
        if (!$user->hasPermissionTo('gerer les devoir', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

           // Récupérer le devoir selon le rôle de l'utilisateur
        if ($user->hasRole('admin')) {
            $Devoir=Devoir::where('id', $request->id)->first();
        }else{
           $Devoir=Devoir::where('id', $request->id)->where('in_creature', $user->id)->first();
        }  
        
         // Vérifier si le devoir a été trouvé
        if ($Devoir) {
            return response()->json($Devoir, 200);
        }else{
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun Devoir trouvé'], 404);
        }
    }

    public function showAll(Request $request)
    {
        // get devoir par class
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission de gérer les devoirs
        if (!$user->hasPermissionTo('gerer les devoir', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

           // Récupérer les devoirs selon le rôle de l'utilisateur et la classe
        if ($user->hasRole('admin')) {
            $Devoir=Devoir::where('in_classe', $request->id)->get();
        }else{
           $Devoir=Devoir::where('in_classe', $request->id)->where('in_creature', $user->id)->get();
        }  
        
        if (count($Devoir)==0) {
            return response()->json('Aucun', 200);
        }

         // Retourner la liste des devoirs paginée
        if ($Devoir) {
            return response()->json($Devoir, 200);
        }else{
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun Devoir trouvé'], 404);
        }
    }

    public function get4Devoir(){
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission de gérer les devoirs
        if (!$user->hasPermissionTo('gerer les devoir', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        if ($user->hasRole('admin')) {
            $Devoir=Devoir::limit(4)->get();
        }else{
           $Devoir=Devoir::where('in_creature', $user->id)->limit(4)->get();
        }     

        if (count($Devoir)==0) {
            return response()->json('Aucun', 200);
        }
        if ($Devoir) {
            return response()->json($Devoir, 200);
        }else{
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun Devoir trouvé'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission de gérer les devoirs
        if (!$user->hasPermissionTo('gerer les devoir', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           } 
  
           // Récupérer le devoir selon le rôle de l'utilisateur
        if ($user->hasRole('admin')) {
            $Devoir=Devoir::where('id', $request->id)->first();
        }else{
            $Devoir=Devoir::where('id', $request->id)->where('in_creature', $user->id)->first();   
        }
        
        
        // Vérifier si le devoir a été trouvé et le supprimer
        if ($Devoir) {
            $Devoir->delete();
            return response()->json(['message' => 'Devoir supprimée avec succès'], 200);
        }else{
            // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun Devoir trouvé'], 404);
        }
    }

    public function statistique($id){
        $user = Auth::user();
        if (!$user->hasPermissionTo('gerer les devoir', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
        } 
        $users=[];
        $statistiques=realise::where('in_Devoir', $id)->get();
        if ($statistiques) {
            $total=count($statistiques);
            foreach($statistiques as $statistique){
                $eleve=User::where('id',$statistique->in_user)->first(['name','email']);
                array_push($users,$eleve);
            }
            return response()->json([
                'total' => $total,
                'statistique'=>$users
            ], 200);
        }else{
            return response()->json(['total' => 0], 200);
        }
    }
}
