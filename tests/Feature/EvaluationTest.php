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

    public function test_guest_cant_rate_eval()  : void {
        $eval = Evaluation::factory()->create();
        $eleve = Utilisateur::factory()->create();

        $eval->utilisateurs()->syncWithoutDetaching([
            $eleve->code => ['note' => 1]
        ]);

        $response = $this->post('saisir_notes',['evaluation_id'=> $eval->id, 'notes'=> [$eleve->code=>["note"=> 4]]]);

        $response->assertStatus(302);

        $noteDonnee = $eval->utilisateurs()->where('code_eleve',$eleve->code)->first();
        $this->assertEquals(1, $noteDonnee->pivot->note);
    }

    public function test_eleve_cant_rate_eval()  : void {
        $eleveConnecte = Utilisateur::factory()->create();
        $eval = Evaluation::factory()->create();
        $eleve = Utilisateur::factory()->create();

        $eval->utilisateurs()->syncWithoutDetaching([
            $eleve->code => ['note' => 1]
        ]);

        $response = $this->actingAs($eleveConnecte)->post('saisir_notes',['evaluation_id'=> $eval->id, 'notes'=> [$eleve->code=>["note"=> 4]]]);

        $response->assertStatus(302);
        $noteDonnee = $eval->utilisateurs()->where('code_eleve',$eleve->code)->first();
        $this->assertEquals(1, $noteDonnee->pivot->note);
    }

    public function test_prof_can_rate_eval()  : void {
        $prof = Utilisateur::factory()->create(['isProf'=>1]);
        $eval = Evaluation::factory()->create();
        $eleve = Utilisateur::factory()->create();

        $eval->utilisateurs()->syncWithoutDetaching([
            $eleve->code => ['note' => 1]
        ]);

        $response = $this->actingAs($prof)->post('saisir_notes',['evaluation_id'=> $eval->id, 'notes'=> [$eleve->code=>["note"=> 4]]]);

        $response->assertStatus(302);
        $noteDonnee = $eval->utilisateurs()->where('code_eleve',$eleve->code)->first();
        $this->assertEquals(4, $noteDonnee->pivot->note);
    }
}
