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
            'priority'=>'in:urgen,Important,non urgent',
            'color'=>'required|string'
        ]);

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

           $Todo=Todo::where('in_creature', $user->id)->get();

        if (count($Todo)==0) {
            return response()->json('Aucun', 200);
        }  
           
        if ($Todo) {
            return response()->json($Todo, 200);
        }
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('gere les todos', 'web')) {
            return response()->json(['message' => 'Non autorise'], 403);
           } 
  
         $Todo=Todo::where('id', $request->id)->where('in_creature', $user->id)->first();   
        
        if ($Todo) {
            $Todo->delete();
            return response()->json(['message' => 'Todo supprimee avec succes'], 200);
        }else{
            return response()->json(['message' => 'Aucun Todo trouve'], 404);
        }
    }
}
