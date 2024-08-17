<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Classe;
use App\Models\Devoir;
use App\Models\Correction;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;

class CorrectionControllerTest extends TestCase
{
    public function test_create_correction_success()
    {
        $user = User::factory()->create();
        $permission = Permission::find(13);
        $user->givePermissionTo($permission);
        $token = JWTAuth::fromUser($user);
        $classe = Classe::factory()->create(['in_user' => $user->id]);
        $devoir = Devoir::factory()->create(['in_classe' => $classe->id,'in_creature'=>$user->id]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/Correction', [
            'description' => 'description Test',
            'id_devoir' => $devoir->id,
            'file' => UploadedFile::fake()->create(Str::random(8).'.pdf'),
        ]);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Correction créée avec succes']);
    }

    public function test_create_correction_unauthorized()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $classe = Classe::factory()->create(['in_user' => $user->id]);
        $devoir = Devoir::factory()->create(['in_classe' => $classe->id,'in_creature'=>$user->id]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/Correction', [
            'description' => 'description Test',
            'id_devoir' => $devoir->id,
            'file' => UploadedFile::fake()->create(Str::random(4).'.pdf'),
        ]);
        $response->assertStatus(403);
        $response->assertJson(['message' => 'Non autorise']);
    }

    public function test_show_correction_as_admin()
    {
        $admin = User::factory()->create();
        $permission = Permission::find(13);
        $admin->givePermissionTo($permission);
        $admin->assignRole('admin');
        $classe = Classe::factory()->create(['in_user' => $admin->id]);
        $devoir = Devoir::factory()->create(['in_classe' => $classe->id,'in_creature'=>$admin->id]);
        $correction = Correction::factory()->create(['id_devoir' => $devoir->id]);

        $response = $this->actingAs($admin)->getJson('/correction/' . $correction->id_devoir);

        $response->assertStatus(200)
                 ->assertJson(['Correction' => $correction->toArray()]);
    }
}
