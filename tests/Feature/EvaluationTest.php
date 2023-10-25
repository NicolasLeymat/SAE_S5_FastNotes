<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Evaluation;
use Tests\TestCase;
use App\Models\Utilisateur;

class EvaluationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_see_evals(): void
    {
        $response = $this->get('/evaluation');
        $this->assertGuest();
        $response->assertStatus(403);
    }

    public function test_eleve_cannot_see_evals(): void
    {
        $user = Utilisateur::factory()->create();

        $response = $this->actingAs($user)->get('evaluation');

        $response->assertStatus(403);
    }

    public function test_prof_can_see_evals(): void
    {
        $user = Utilisateur::factory()->create(['isProf' =>1]);

        $response = $this->actingAs($user)->get('evaluation');

        $response->assertStatus(200);
    }

    public function guest_cant_rate_eval()  : void {
        $eval = Evaluation::factory()->create();
        $eleve = Utilisateur::factory()->create();

        $eval->utilisateurs()->syncWithoutDetaching([
            $eleve => ['note' => 1]
        ]);

        $response = $this->post('/evaluation/'.$eval->id,['evaluation_id'=> $eval->id, "'notes[".$eleve->code."]'" => 4]);
    }
}
