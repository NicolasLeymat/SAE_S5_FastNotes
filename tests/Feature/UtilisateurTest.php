<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Utilisateur;
use Tests\TestCase;

class UtilisateurTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_cant_see_notes(): void
    {
        $user = Utilisateur::factory()->create();

        $response = $this->get('visualisation/'.$user->code);

        $response->assertStatus(403);

    }

    public function test_eleve_can_see_his_notes(): void
    {
        $user = Utilisateur::factory()->create();

        $response = $this->actingAs($user)->get('visualisation/'.$user->code);

        $response->assertStatus(200);

    }

    public function test_eleve_can_only_see_his_notes(): void
    {
        $user = Utilisateur::factory()->create();
        $user2 = Utilisateur::factory()->create();

        $response = $this->actingAs($user)->get('visualisation/'.$user2->code);

        $response->assertStatus(403);

    }
}
