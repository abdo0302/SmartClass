<?php

namespace Tests\Unit;

use Tests\TestCase;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Classe;
use App\Models\Sinscrit;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Faker\Factory as Faker;

class SinscritControllerTest extends TestCase
{
    public function testCreateSinscrit()
    {
        // Crée un nouvel utilisateur
        $user = User::factory()->create();

         // Trouve une permission spécifique et attribue-la à l'utilisateur
        $permission = Permission::find(1);
        $user->givePermissionTo($permission);

        // Génère un jeton JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Crée un élève et une classe associée à l'utilisateur
        $eleve = User::factory()->create();
        $classe = Classe::factory()->create(['in_user' => $user->id]);

        // Envoi d'une requête POST
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/inscrit', [
            'date_inscription' => now()->toDateString(),
            'in_eleve' => $eleve->id,
            'in_classe' => $classe->id,
        ]);

         // Vérifie que la réponse a le code de statut HTTP 201
        $response->assertStatus(201);
        $response->assertJson(['message' => 'sinscrit avec succès']);
    
    }

    public function testShowSinscrit()
    {
        // Crée un nouvel utilisateur
        $user = User::factory()->create();

        // Trouve une permission spécifique et attribue-la à l'utilisateur
        $permission = Permission::find(1);
        $user->givePermissionTo($permission);

        // Génère un jeton JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Crée une classe associée à l'utilisateur et une inscription pour cette classe
        $classe = Classe::factory()->create(['in_user' => $user->id]);
        $sinscrit = Sinscrit::factory()->create(['in_classe' => $classe->id]);

        // Envoie une requête GET
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/inscrit/'. $classe->id);
       
        // Vérifie que la réponse a le code de statut HTTP 200 (OK)
        $response->assertStatus(200);
             
    }

    public function test_destroy_success(){
        // Crée un nouvel utilisateur
        $user = User::factory()->create();

        // Trouve une permission spécifique et attribue-la à l'utilisateur
        $permission = Permission::find(1);
        $user->givePermissionTo($permission);

        // Génère un jeton JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Crée une classe associée à l'utilisateur et une inscription pour cette classe
        $classe = Classe::factory()->create(['in_user' => $user->id]);
        $sinscrit = Sinscrit::factory()->create(['in_classe' => $classe->id]);

        // Envoie une requête DELETE
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/inscrit/' . $sinscrit->id);

         // Vérifie que la réponse a le code de statut HTTP 200
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Sinscrit supprimée avec succès']);
    }
}
