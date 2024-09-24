<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function showAll(){
        $user = Auth::user();
        $notifications = Notification::where('user',$user->id)->get();
        if ($notifications) {
            return response()->json($notifications, 200);
        }
    }

    public function destroy(){
        $user = Auth::user();
        $notifications = Notification::where('user',$user->id)->get();
        if ($notifications) {
            foreach ($notifications as $notification) {
                $notification->delete();
            }
            return response()->json(['message' => 'Notification supprimée avec succès'], 200);
        }
    }
}
