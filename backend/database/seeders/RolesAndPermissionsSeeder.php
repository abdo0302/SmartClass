<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // les rôles
         $adminRole = Role::create(['name' => 'admin']);
         $professeurRole = Role::create(['name' => 'professeur']);
         $eleveRole = Role::create(['name' => 'eleve']);
         // les Permission
         $inscriAclassPermission = Permission::create(['name' => 'inscrire les élève dans class']);
         $creerFeedbackPermission = Permission::create(['name' => 'creer Feedback']);
         $accesAcontenuPermission = Permission::create(['name' => 'acces au contenu']);
         $accesClassPermission = Permission::create(['name' => 'acces au class']);
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

         // Attribution de la permission au rôle

         $adminRole->givePermissionTo([$inscriAclassPermission, $creerFeedbackPermission, $accesAcontenuPermission, $accesAsessionLivePermission, $gererClassPermission, $suiviElevPermission, $gererDevoirPermission, $gererSessionLivePermission,$envoyEmailPermission, $corrgiDevoirPermission, $gereContenusPermission, $gererElevePermission, $gererUtilisateurPermission, $gererStatistiquePermission ,$accesClassPermission]);
         $professeurRole->givePermissionTo([$inscriAclassPermission, $creerFeedbackPermission, $accesAcontenuPermission, $accesAsessionLivePermission, $gererClassPermission, $suiviElevPermission, $gererDevoirPermission, $gererSessionLivePermission,$envoyEmailPermission, $corrgiDevoirPermission, $gereContenusPermission, $gererElevePermission ,$accesClassPermission]);
         $eleveRole->givePermissionTo([$creerFeedbackPermission, $accesAsessionLivePermission ,$accesClassPermission]);
    }
}
