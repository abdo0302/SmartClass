<?php

namespace App\Http\Controllers;

use App\Models\Correction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorrectionController extends Controller
{

    public function create(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a la permission 'correction des devoir'
        if (!$user->hasPermissionTo('correction des devoir', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           }

        // Valider les données de la requête
           $validatedData = $request->validate([
            'description' => 'required|string',
            'id_devoir' => 'required|integer',
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,webp,pdf,docx,mp4|max:2048',
        ]);

        // Vérifier si un fichier a été téléchargé
        if ($request->hasFile('file')) {
            $file = $request->file('file');
             // Générer un nom de fichier unique
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // Déplacer le fichier vers le répertoire public/file
            $file->move(public_path('file'), $fileName);
            // Ajouter le chemin du fichier dans les données validées
            $validateDta['file'] = 'file/' . $fileName;
            // Récupérer le type MIME du fichier
            $mimeType = $file->getClientMimeType();
            // Ajouter le type MIME aux données validées
            $validatedData['file'] = 'file/' . $fileName;
            $validatedData['typ_file'] = $mimeType;
        }

        // Ajouter l'ID de l'utilisateur qui a créé la correction aux données validées
        $validatedData['in_creature']=$user->id;

        // Créer une nouvelle instance de Correction avec les données validées
        $Correction = Correction::create($validatedData);

            // Vérifier si la correction a été créée avec succès
            if ($Correction) {
                return response()->json(['message' => 'Correction créée avec succes'], 201);
            } else {
                // Retourner un message d'erreur 
                return response()->json(['message' => 'Echec de la creation du Correction'], 500);
            }   
    }

    public function show(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
    
         // Vérifier si l'utilisateur a la permission 'acces au correction'
        if (!$user->hasPermissionTo('acces au correction', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           }

           // Vérifier si l'utilisateur a le rôle 'admin' ou 'eleve'
        if ($user->hasRole('admin') || $user->hasRole('eleve')) {
            // Si oui, récupérer la correction correspondant à l'id_devoir
            $Correction=Correction::where('id_devoir', $request->id)->first();
        }else{
            // Sinon, récupérer la correction correspondant à l'id_devoir et créée par l'utilisateur
           $Correction=Correction::where('id_devoir', $request->id)->where('in_creature', $user->id)->first();
        }  
        
        // Vérifier si la correction a été trouvée
        if ($Correction) {
            return response()->json(['Correction' => $Correction], 200);
        }else{
             // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun Correction trouve'], 404);
        }
    }

    public function destroy(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();
         // Vérifier si l'utilisateur a la permission 'correction des devoir'
        if (!$user->hasPermissionTo('correction des devoir', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           } 
  

           // Vérifier si l'utilisateur a le rôle 'admin'
        if ($user->hasRole('admin')) {
            // Si oui, récupérer la correction par ID
            $Correction=Correction::where('id', $request->id)->first();
        }else{
            // Sinon, récupérer la correction par ID seulement si elle a été créée par l'utilisateur
            $Correction=Correction::where('id', $request->id)->where('in_creature', $user->id)->first();   
        }
        
        // Vérifier si la correction a été trouvée
        if ($Correction) {
             // Supprimer la correction
            $Correction->delete();
            return response()->json(['message' => 'Correction supprimee avec succes'], 200);
        }else{
            // Retourner un message d'erreur 
            return response()->json(['message' => 'Aucun Correction trouve'], 404);
        }
    }
}
