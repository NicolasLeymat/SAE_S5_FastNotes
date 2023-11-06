<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Utilisateur;
use App\Models\Evaluation;
use App\Models\Competence;
use App\Models\Ressource;
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



    public function test_moyenne(): void
    {
        
        $user = Utilisateur::factory()->create();
        $this->actingAs($user);
        $competence = Competence::factory()->create();
        $ressource = Ressource::factory()->create();
        
        $ressource->competences()->syncWithoutDetaching([
            $competence->code => ['coefficient' => 1]
        ]);
        
        $eval = Evaluation::factory()->create(['coefficient' => 1, 'code_ressource' => $ressource]);
        $eval2 = Evaluation::factory()->create(['coefficient' => 1,'code_ressource' => $ressource ]);   
        
        $eval->utilisateurs()->syncWithoutDetaching([
            $user->code => ['note' => 10]
        ]);

        $eval2->utilisateurs()->syncWithoutDetaching([
            $user->code => ['note' => 5]
        ]);

        $noteDonnee = $eval->ressource->competences()->where('code_ressource',$ressource->code)->first();
        $this->assertEquals($ressource->code, $noteDonnee->pivot->code_ressource);
 
        $controller = app(EleveController::class);
        $code = $competence->code;
        $moyenne = $controller->moyenneSemestre($user->code);
        assertEquals(7.5,$moyenne);
    }

}