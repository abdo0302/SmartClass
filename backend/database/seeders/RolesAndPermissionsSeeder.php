<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // les rôles
         $adminRole = Role::create(['name' => 'admin']);
         $professeurRole=Role::create(['name' => 'professeur']);
         $eleveRole=Role::create(['name' => 'eleve']);
         // les Permission
         $inscriAclassPermission = Permission::create(['name' => 'inscrire les élève dans class']);
         $creerFeedbackPermission = Permission::create(['name' => 'creer Feedback']);
         $accesAcontenuPermission = Permission::create(['name' => 'acces au contenu']);
         $accesClassPermission = Permission::create(['name' => 'acces au class']);
         $accesAdevoirPermission = Permission::create(['name' => 'acces au devoir']);
         $accesAcorrectionPermission = Permission::create(['name' => 'acces au correction']);
         $accesAsessionLivePermission = Permission::create(['name' => 'acces au session live']);
         $gererClassPermission = Permission::create(['name' => 'gerer class']);
         $suiviElevPermission = Permission::create(['name' => 'suivi les eleves']);
         $gererDevoirPermission = Permission::create(['name' => 'gerer les devoir']);
         $gererSessionLivePermission = Permission::create(['name' => 'gerer Session live']);
         $envoyEmailPermission = Permission::create(['name' => 'envoyer un email']);
         $corrgiDevoirPermission = Permission::create(['name' => 'correction des devoir']);
         $gereContenusPermission = Permission::create(['name' => 'gere les contenus']);
         $gererElevePermission = Permission::create(['name' => 'gere les eleve']);
         $gererUtilisateurPermission = Permission::create(['name' => 'gere les utilisateurs']);
         $gererStatistiquePermission = Permission::create(['name' => 'gere les statistiques']);
         $gererTodoPermission = Permission::create(['name' => 'gere les todos']);

         // Attribution de la permission au rôle

         $adminRole->givePermissionTo([$inscriAclassPermission, $creerFeedbackPermission, $accesAcontenuPermission, $accesAsessionLivePermission, $gererClassPermission, $suiviElevPermission, $gererDevoirPermission, $gererSessionLivePermission,$envoyEmailPermission, $corrgiDevoirPermission, $gereContenusPermission, $gererElevePermission, $gererUtilisateurPermission, $gererStatistiquePermission ,$accesClassPermission,$accesAcorrectionPermission, $gererTodoPermission]);
         $professeurRole->givePermissionTo([$inscriAclassPermission, $creerFeedbackPermission, $accesAcontenuPermission, $accesAsessionLivePermission, $gererClassPermission, $suiviElevPermission, $gererDevoirPermission, $gererSessionLivePermission,$envoyEmailPermission, $corrgiDevoirPermission, $gereContenusPermission, $gererElevePermission ,$accesClassPermission ,$accesAcorrectionPermission ,$gererTodoPermission]);
         $eleveRole->givePermissionTo([$creerFeedbackPermission, $accesAsessionLivePermission ,$accesClassPermission ,$accesAdevoirPermission ,$accesAcorrectionPermission ,$gererTodoPermission]);
    
    
    
    
         $token = Str::random(80);
         $user = User::create([
            'name' => 'admin',
            'email' =>'admin@gmail.com' ,
            'password' => bcrypt('password'),
            'token'=>bcrypt($token)
        ]);

         $user->assignRole('admin');
        }
}
