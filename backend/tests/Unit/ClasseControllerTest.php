<?php

namespace Tests\Unit;

use Faker\Factory as Faker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Classe as Session;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClasseControllerTest extends TestCase
{
    public function test_user_can_create_classe()
    {
        // Création d'un utilisateur en utilisant une factory
        $user = User::factory()->create();

        // Attribution du permission 'gerer class' à l'utilisateur
        $permission = Permission::where('name', 'gerer class')->where('guard_name', 'web')->first();
        $user->givePermissionTo('gerer class');

        // Génération d'un token JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Envoi d'une requête POST
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/classe', [
            'name' => 'Classe Test' .Str::random(6),
        ]);

         // Vérification du statut de la réponse et du message JSON
        $response->assertStatus(201)
                 ->assertJson(['message' => 'Classe créée avec succès']);
    }

    public function test_user_not_authenticated()
    {   
        // test get all classes

        // Création d'un utilisateur en utilisant une factory
        $user = User::factory()->create();

        // Génération d'un token JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Envoi d'une requête GET
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/classes');

        // Vérification du statut de la réponse et du message JSON
        $response->assertStatus(403);
        $response->assertJson(['message' => 'Non autorisé']);
    }

    public function test_destroy_success()
    {
        // Création d'un utilisateur en utilisant une factory
        $user = User::factory()->create();

        // Attribution du permission 'gerer class' à l'utilisateur
        $permission = Permission::where('name', 'gerer class')->where('guard_name', 'web')->first();
        $user->givePermissionTo('gerer class');

         // Génération d'un token JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Création d'une classe appartenant à l'utilisateur
        $classe = Session::factory()->create(['in_user' => $user->id]);

        // Envoi d'une requête DELETE pour supprimer la classe
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/classe/' . $classe->id);

        // Vérification du statut de la réponse et du message JSON
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Classe supprimée avec succès']);
    }

    public function test_update_success()
    {
        // Création d'un utilisateur en utilisant une factory
        $user = User::factory()->create();

        // Attribution du permission 'gerer class' à l'utilisateur
        $permission = Permission::where('name', 'gerer class')->where('guard_name', 'web')->first();
        $user->givePermissionTo('gerer class');

        // Génération d'un token JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Création d'une classe appartenant à l'utilisateur
        $classe = Session::factory()->create(['in_user' => $user->id]);

        // Envoi d'une requête POST pour mettre à jour la classe
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/classe/update/' . $classe->id);

        // Vérification du statut de la réponse et du message JSON
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Classe mise à jour avec succès']);
    }
}
