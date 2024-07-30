<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Role::count() == 0) {
            // les rôles
            $adminRole = Role::create(['name' => 'admin']);
            $professeurRole = Role::create(['name' => 'professeur']);
            $eleveRole = Role::create(['name' => 'eleve']);
            // les Permission
            $inscriAclassPermission = Permission::create(['name' => 'inscrire a class']);
            $creerFeedbackPermission = Permission::create(['name' => 'creer Feedback']);
            $accesAcontenuPermission = Permission::create(['name' => 'acces au contenu']);
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

            $adminRole->givePermissionTo([$inscriAclassPermission, $creerFeedbackPermission, $accesAcontenuPermission, $accesAsessionLivePermission, $gererClassPermission, $suiviElevPermission, $gererDevoirPermission, $gererSessionLivePermission,$envoyEmailPermission, $corrgiDevoirPermission, $gereContenusPermission, $gererElevePermission, $gererUtilisateurPermission, $gererStatistiquePermission]);
            $professeurRole->givePermissionTo([$inscriAclassPermission, $creerFeedbackPermission, $accesAcontenuPermission, $accesAsessionLivePermission, $gererClassPermission, $suiviElevPermission, $gererDevoirPermission, $gererSessionLivePermission,$envoyEmailPermission, $corrgiDevoirPermission, $gereContenusPermission, $gererElevePermission]);
            $eleveRole->givePermissionTo([$inscriAclassPermission, $creerFeedbackPermission, $accesAcontenuPermission, $accesAsessionLivePermission]);
            
        }
    }
}
