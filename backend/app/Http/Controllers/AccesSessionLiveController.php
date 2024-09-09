<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\Classe;
use App\Models\Sinscrit;
use App\Models\User;
use App\Services\AblyNotificationService;

class AccesSessionLiveController extends Controller
{
    protected $ablyNotificationService;

    public function __construct(AblyNotificationService $ablyNotificationService)
    {
        $this->ablyNotificationService = $ablyNotificationService;
    }
    public function show(Request $request){
        $user = Auth::user();
        if (!$user->hasPermissionTo('acces au session live', 'web')) {
            return response()->json(['message' => 'Non autorisé'], 403);
           }
        $Room=Room::where('id_class', $request->id)->first();  
        if ($Room) {
            $class=Classe::where('id', $request->id)->first();
            if ($class->in_user==$user->id) {          
                    $Sinscrits=Sinscrit::where('in_classe', $request->id)->get();
                    foreach ($Sinscrits as $sinscrit) {
                        $eleve=User::where('id', $sinscrit->in_eleve)->get();
                        $message = 'La conférence a commencé dans la class '.$class->name;
                        $this->ablyNotificationService->sendNotification($eleve[0]->token, $message);
                    }
            }
            if ($class) {
                
            }
            return response()->json($Room->name, 200);
        }
    }
}
