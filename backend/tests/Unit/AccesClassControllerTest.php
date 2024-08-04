<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Classe;
use App\Models\Sinscrit;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AccesClassControllerTest extends TestCase
{
    public function test_returns_classes_for_student()
    {
         // Crée un nouvel utilisateur et assigne le rôle 'eleve'
        $user = User::factory()->create();
        $user->assignRole('eleve');

        // Crée une nouvelle classe
        $classe = Classe::factory()->create();

         // Génère un jeton JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Crée une nouvelle inscription (Sinscrit) pour associer l'élève à la classe
        Sinscrit::factory()->create(['in_eleve' => $user->id,'in_classe' => $classe->id,
        ]);

        // Envoie une requête GET
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/accesclass');
        
        // Vérifie que la réponse a le code de statut HTTP 201 (Créé)
        $response->assertStatus(201);
        // Vérifie que la réponse JSON
        $response->assertJsonFragment(['id' => $classe->id]);
    }
}
