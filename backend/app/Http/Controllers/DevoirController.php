<?php

namespace App\Http\Controllers;

use App\Models\Devoir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevoirController extends Controller
{
   
    public function create(Request $request)
    {
        $user = Auth::user();
        // Vérifier si l'utilisateur a la permission de gérer les devoirs
        if (!$user->hasPermissionTo('gerer les devoir', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

         // Valider les données du formulaire
           $validatedData = $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,webp,pdf,docx,mp4|max:2048',
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
                return response()->json(['message' => 'Devoir créée avec succès'], 201);
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
            return response()->json(['Devoir' => $Devoir], 200);
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
            $Devoir=Devoir::where('in_classe', $request->id)->paginate(10);
        }else{
           $Devoir=Devoir::where('in_classe', $request->id)->where('in_creature', $user->id)->paginate(10);
        }  
        
         // Retourner la liste des devoirs paginée
        if ($Devoir) {
            return response()->json(['Devoir' => $Devoir], 200);
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
}
