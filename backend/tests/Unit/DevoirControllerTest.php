<?php

namespace Tests\Unit;

use Tests\TestCase;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Classe as Session;
use App\Models\Devoir;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;

class DevoirControllerTest extends TestCase
{
    public function test_create_devoir()
    {
        // Crée un utilisateur avec les données de la fabrique d'utilisateurs
       $user = User::factory()->create();

       // Récupère une permission spécifique par son ID et l'assigne à l'utilisateur
       $permission = Permission::find(10);
       $user->givePermissionTo($permission);

       // Génère un token JWT pour l'utilisateur créé
       $token = JWTAuth::fromUser($user);
 
       // Crée une classe associée à l'utilisateur
       $classe = Session::factory()->create(['in_user' => $user->id]);

       //Effectue une requête POST à l'endpoint API pour créer un devoir
       $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/devoir', [
           'titre' =>  Str::random(6),
            'description' => 'test description',
            'file' => UploadedFile::fake()->create('testfile.pdf'),
            'in_classe' => $classe->id,

       ]);

       // Vérifie que la réponse HTTP a un code de statut 201 (créé)
       $response->assertStatus(201);
       // Vérifie que la réponse JSON contient le message attendu
       $response->assertJson(['message' => 'Devoir créée avec succès']); 
    }

    public function test_user_without_permission_cannot_create_a_devoir()
    {
        // Crée un utilisateur sans permissions spécifiques
       $user = User::factory()->create();

       // Génère un token JWT pour l'utilisateur créé
       $token = JWTAuth::fromUser($user);

       // Crée une classe associée à l'utilisateur
       $classe = Session::factory()->create(['in_user' => $user->id]);

       // Génère un numéro aléatoire pour le titre du devoir
       $randomNumber=rand(1, 40);
       // Effectue une requête POST à l'endpoint API pour créer un devoir
       $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/devoir', [
           'titre' => 'titre'.$randomNumber,
            'description' => 'test description',
            'in_classe' => $classe->id,
       ]);

       // Vérifie que la réponse HTTP a un code de statut 403 (interdit)
       $response->assertStatus(403);
       // Vérifie que la réponse JSON contient le message d'erreur attendu
       $response->assertJson(['message' => 'Non autorisé']);
    
    }

    public function test_show_devoir_user()
    {
        // Crée un utilisateur avec les permissions nécessaires
       $user = User::factory()->create();
       $permission = Permission::find(10);
       $user->givePermissionTo($permission);

       // Génère un token JWT pour l'utilisateur créé
       $token = JWTAuth::fromUser($user);

       // Crée une classe associée à l'utilisateur
       $classe = Session::factory()->create(['in_user' => $user->id]);

       // Crée un devoir associé à la classe et à l'utilisateur
       $devoir = Devoir::factory()->create(['in_classe' => $classe->id,'in_creature'=>$user->id]);

       // Effectue une requête GET à l'endpoint API pour obtenir les détails du devoir
       $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/devoir/'.$devoir->id);
       
       // Vérifie que la réponse HTTP a un code de statut 200 (OK)
       $response->assertStatus(200);

       // Vérifie que la réponse JSON contient les détails du devoir
       $response->assertJson(['Devoir' => [
                     'id' => $devoir->id,
                     'titre' => $devoir->titre,
                     'description' => $devoir->description,
                     'in_classe' => $devoir->in_classe,
                 ]]);
    }

    public function test_user_without_permission_cannot_show_a_devoir(){
        // Crée un utilisateur sans permissions spécifiques
       $user = User::factory()->create();

       // Génère un token JWT pour l'utilisateur créé
       $token = JWTAuth::fromUser($user);
       // Crée une classe associée à l'utilisateur
       $classe = Session::factory()->create(['in_user' => $user->id]);

       // Crée un devoir associé à la classe et à l'utilisateur
       $devoir = Devoir::factory()->create(['in_classe' => $classe->id,'in_creature'=>$user->id]);
       $randomNumber=rand(1, 40);

       // Effectue une requête GET à l'endpoint API pour obtenir les détails du devoir
       $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/devoir/'.$devoir->id);
       // Vérifie que la réponse HTTP a un code de statut 403 (interdit)
       $response->assertStatus(403);
       // Vérifie que la réponse JSON contient le message d'erreur attendu
       $response->assertJson(['message' => 'Non autorisé']);
    }

    public function test_showAll_devoir_user()
    {
        // Crée un utilisateur avec les permissions nécessaires
        $user = User::factory()->create();
       $permission = Permission::find(10);
       $user->givePermissionTo($permission);

       // Génère un token JWT pour l'utilisateur créé
       $token = JWTAuth::fromUser($user);
       // Crée une classe associée à l'utilisateur
       $classe = Session::factory()->create(['in_user' => $user->id]);

       // Effectue une requête GET à l'endpoint API pour obtenir la liste des devoirs pour la classe
       $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/devoirs/'.$classe->id);
        // Vérifie que la réponse HTTP a un code de statut 200 (OK)
       $response->assertStatus(200);
    }

}
