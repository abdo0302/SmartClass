<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Mail;
use Faker\Factory as Faker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    public function testRegister(){
        // Utilisation de la librairie Faker pour générer une adresse email unique
        $faker = Faker::create();
        $email = $faker->unique()->safeEmail;

         // Envoi d'une requête POST
        $response = $this->post('/api/auth/register', [
            'name' => 'Test User',
            'email' => $email,
            'password' => 'password12',
            'password_confirmation' => 'password12',
            'role' => 'eleve',
            ]);

            // Assertion pour vérifier que la réponse a un statut HTTP 200
           // et que la structure JSON contient 'access_token', 'token_type' et 'expires_in'
            $response->assertStatus(200)->assertJsonStructure(['access_token','token_type','expires_in',]);
    }

    public function testLogin(){
        // Création d'un utilisateur en utilisant une factory et en hashant le mot de passe
        $user = User::factory()->create([
            'password' => Hash::make('password90'),
        ]);


        // Envoi d'une requête POST
        $response = $this->post('/api/auth/login', [
            'email' =>$user->email,
            'password' => 'password90',
            ]);

             // Assertion pour vérifier que la réponse a un statut HTTP 200
            // et que la structure JSON contient 'access_token', 'token_type' et 'expires_in'
            $response->assertStatus(200);
            $response->assertJsonStructure(['access_token','token_type','expires_in',]);    
    }

    public function testMe(){
        // Création d'un utilisateur en utilisant une factory
        $user = User::factory()->create();

        // Génération d'un token JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

        // Envoi d'une requête POST
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/me');

        // Assertion pour vérifier que la réponse a un statut HTTP 200
        // et que les données JSON retournées correspondent à celles de l'utilisateur
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testLogout()
    {
        // Création d'un utilisateur en utilisant une factory
        $user = User::factory()->create();

        // Génération d'un token JWT pour l'utilisateur
        $token = JWTAuth::fromUser($user);

         // Envoi d'une requête POST
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->post('/api/logout');

         // Assertion pour vérifier que la réponse a un statut HTTP 200
         // et que le message JSON retourné est 'Successfully logged out'                 
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully logged out',
        ]);
    }
}
