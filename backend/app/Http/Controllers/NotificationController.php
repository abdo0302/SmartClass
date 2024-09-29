<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Affiche toutes les notifications de l'utilisateur
    public function showAll(){
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Récupère les notifications de l'utilisateur
        $notifications = Notification::where('user',$user->id)->get();

        // Si des notifications sont trouvées, les renvoie
        if ($notifications) {
            return response()->json($notifications, 200);
        }
    }

    // Supprime toutes les notifications de l'utilisateur
    public function destroy(){

        // Récupère l'utilisateur connecté
        $user = Auth::user();
        // Récupère les notifications de l'utilisateur
        $notifications = Notification::where('user',$user->id)->get();
        // Si des notifications sont trouvées, les supprime
        if ($notifications) {
            foreach ($notifications as $notification) {
                $notification->delete();
            }
            return response()->json(['message' => 'Notification supprimée avec succès'], 200);
        }
    }
}
