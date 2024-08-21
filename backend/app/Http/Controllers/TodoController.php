<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           }

           $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,pdf,docx,mp4|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file'), $fileName);
            $validateDta['file'] = 'file/' . $fileName;
            $mimeType = $file->getClientMimeType();
            $validatedData['file'] = 'file/' . $fileName;
            $validatedData['typ_file'] = $mimeType;
        }

        $validatedData['in_creature']=$user->id;

        $Todo = Todo::create($validatedData);

            if ($Todo) {
                return response()->json(['message' => 'Not créée avec succes'], 201);
            } else {
                return response()->json(['message' => 'Echec de la creation du Not'], 500);
            }   
    }

    public function show(Request $request)
    {
        $user = Auth::user();
    
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           }

        if ($user->hasRole('admin')) {
            $Todo=Todo::where('id', $request->id)->first();
        }else{
           $Todo=Todo::where('id', $request->id)->where('in_creature', $user->id)->first();
        }  
        
        if ($Todo) {
            return response()->json(['Not' => $Todo], 200);
        }else{
            return response()->json(['message' => 'Aucun Not trouve'], 404);
        }
    }

    public function showAll(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

           $Todo=Todo::where('in_creature', $user->id)->paginate(10);

        if ($Todo) {
            return response()->json(['Nots' => $Todo], 200);
        }else{
            return response()->json(['message' => 'Aucun Nots trouvé'], 404);
        }
    }

    public function showAll_admin(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }

        if ($user->hasRole('admin')) {
            $Todo=Todo::paginate(10);
        }
        
        if ($Todo) {
            return response()->json(['Nots' => $Todo], 200);
        }else{
            return response()->json(['message' => 'Aucun Nots trouvé'], 404);
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
          $id=$request->id;
          $Todo=Todo::findOrFail($id); 

          $validatedData = $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,pdf,docx,mp4|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file'), $fileName);
            $validateDta['file'] = 'file/' . $fileName;
            $mimeType = $file->getClientMimeType();
            $validatedData['file'] = 'file/' . $fileName;
            $validatedData['typ_file'] = $mimeType;
        }

        $Todo->update($validatedData);

          return response()->json(['message' => 'Todo mise à jour avec succès'], 200);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           } 
  
        if ($user->hasRole('admin')) {
            $Todo=Todo::where('id', $request->id)->first();
        }else{
            $Todo=Todo::where('id', $request->id)->where('in_creature', $user->id)->first();   
        }
        
        if ($Todo) {
            $Todo->delete();
            return response()->json(['message' => 'Todo supprimee avec succes'], 200);
        }else{
            return response()->json(['message' => 'Aucun Todo trouve'], 404);
        }
    }
}
