<?php

namespace Tests\Unit;

use Tests\TestCase;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Classe as Session;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Faker\Factory as Faker;

class userControllerTest extends TestCase
{
    public function test_showAll_users_admin()
    {
        // Crée un utilisateur avec le rôle d'administrateur
        $user =User::factory()->create();
        $user->assignRole('admin');

         // Génère un token JWT pour l'utilisateur administrateur
        $token = JWTAuth::fromUser($user);

        // Effectue une requête GET à l'endpoint API pour obtenir la liste des utilisateurs
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/users');
        
        // Vérifie que la réponse HTTP a un code de statut 201 (créé)
        $response->assertStatus(201);
    }

    public function test_showAll_users_noAdmin()
    {
         // Crée un utilisateur sans rôle d'administrateur
        $user =User::factory()->create();

        // Génère un token JWT pour cet utilisateur
        $token = JWTAuth::fromUser($user);
        // Effectue une requête GET à l'endpoint API pour obtenir la liste des utilisateurs
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/users');
        
        // Vérifie que la réponse HTTP a un code de statut 403 (Interdit)
        $response->assertStatus(403);
        // Vérifie que la réponse JSON contient le message d'erreur attendu
        $response->assertJson(['message' => 'Non autorisé',]);
    }

    public function test_show_users_admin()
    {
        // Crée un utilisateur avec le rôle d'administrateur
        $admin =User::factory()->create();
        $admin->assignRole('admin');

        // Génère un token JWT pour l'utilisateur administrateur
        $token = JWTAuth::fromUser($admin);

        // Crée un autre utilisateur dont les détails seront récupérés
        $user=User::factory()->create();
        // Effectue une requête GET à l'endpoint API pour obtenir les détails de l'utilisateur spécifique
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/user/' . $user->id);
       
        // Vérifie que la réponse HTTP a un code de statut 201 (créé)
        $response->assertStatus(201);
        // Vérifie que la réponse JSON contient les détails de l'utilisateur
        $response->assertJson(['User' => ['id' => $user->id, 'name' => $user->name,],]);
    }

    public function test_show_users_noAdmin()
    {
        // Crée un utilisateur sans rôle d'administrateur
        $admin =User::factory()->create();

        // Génère un token JWT pour cet utilisateur
        $token = JWTAuth::fromUser($admin);

        // Crée un autre utilisateur dont les détails seront récupérés
        $user=User::factory()->create();
        // Effectue une requête GET à l'endpoint API pour obtenir les détails de l'utilisateur spécifique
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/user/' . $user->id);
        
        // Vérifie que la réponse HTTP a un code de statut 403 (Interdit)
        $response->assertStatus(403);
        // Vérifie que la réponse JSON contient le message d'erreur attendu
        $response->assertJson(['message' => 'Non autorisé',]);
    }

    public function test_a_user_can_update_their_own_details()
    {
         // Crée un générateur de données aléatoires
        $faker = Faker::create();

        // Génère un email unique aléatoire
        $email = $faker->unique()->safeEmail;

        // Crée un utilisateur et génère un token JWT pour cet utilisateur
        $user =User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Effectue une requête POST à l'endpoint API pour mettre à jour les détails de l'utilisateur
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/user/update',[
            'name' => 'Updated Name',
            'email' => $email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        // Vérifie que la réponse HTTP a un code de statut 201 (créé)
        $response->assertStatus(201);
        // Vérifie que la réponse JSON contient le message de succès attendu
        $response->assertJson(['message' => 'Votre compte à jour avec succès']);
    }

    public function test_delete_users_admin()
    {
        // Crée un utilisateur et lui assigne le rôle d'administrateur
        $admin =User::factory()->create();
        $admin->assignRole('admin');

        // Crée un autre utilisateur qui sera supprimé
        $User = User::factory()->create();
        // Génère un token JWT pour l'utilisateur administrateur
        $token = JWTAuth::fromUser($admin);

        // Effectue une requête DELETE à l'endpoint API pour supprimer l'utilisateur
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/user/'.$User->id);
        
        // Vérifie que la réponse HTTP a un code de statut 201 (Créé)
        $response->assertStatus(201);
        // Vérifie que la réponse JSON contient le message de succès attendu
        $response->assertJson(['message' => 'User supprimée avec succès']);
    }
}
