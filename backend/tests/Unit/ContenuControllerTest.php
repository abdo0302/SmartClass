<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;

class ContenuControllerTest extends TestCase
{
        public function test_create_contenu()
        {
            // Crée un utilisateur fictif
            $user = User::factory()->create();

            // Récupère la permission avec l'ID 14 et l'assigne à l'utilisateur
            $permission = Permission::find(14);
            $user->givePermissionTo($permission);

             // Génère un token JWT pour l'utilisateur
            $token = JWTAuth::fromUser($user);

            // Crée une classe fictive associée à l'utilisateur
            $classe = Classe::factory()->create(['in_user' => $user->id]);

            // Effectue une requête POST pour créer un contenu
            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/contenu', [
                'titre' => 'Test Title',
                'description' => 'Test Description',
                'file' => UploadedFile::fake()->create('testfile.pdf'),
                'in_classe' =>$classe->id ,
            ]);
            // Vérifie que la réponse a le statut HTTP 201 (Created)
            $response->assertStatus(201);
            // Vérifie que la réponse JSON
            $response->assertJson(['message' => 'Contenu cree avec succes']);
        }

        public function test_show_all_contenu(){
             // Crée un utilisateur fictif
            $user = User::factory()->create();

            // Récupère la permission avec l'ID 14 et l'assigne à l'utilisateur
            $permission = Permission::find(14);
            $user->givePermissionTo($permission);

             // Génère un token JWT pour l'utilisateur
            $token = JWTAuth::fromUser($user);

             // Crée une classe fictive associée à l'utilisateur
            $classe = Classe::factory()->create(['in_user' => $user->id]);
            // Effectue une requête GET pour afficher tous les contenus de la classe
            $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/contenus/'. $classe->id);
            // Vérifie que la réponse a le statut HTTP 200
            $response->assertStatus(200);
            // Vérifie que la réponse JSON a la structure attendue
            $response->assertJsonStructure(['Contenus' => ['data']]);
        }
}
