<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class AccesSessionLiveController extends Controller
{
    public function show(Request $request){
        $user = Auth::user();
        if (!$user->hasPermissionTo('acces au session live', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
        $Room=Room::where('id_class', $request->id)->first();  
        if ($Room) {
            return response()->json(['name rome' =>$Room->name ], 200);
        }
    }
}
