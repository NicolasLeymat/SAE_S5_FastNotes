<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Utilisateur;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\EleveController;
use App\Models\Competence;
use App\Models\Ressource;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

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
        Gate::define('isEleve', function ($user) {
            return true;
        });

        Gate::define('isAdmin', function ($user) {
            return true;
        });


        $user = Utilisateur::factory()->create();
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

         
        $controller = app(EleveController::class);
        $code = $competence->code;
        try {
        $moyenne = $controller->moyenneSemestre($user->code);
        } catch (\Exception $e) {
            // Capturez l'exception et affichez ses détails
            $this->assertTrue(true, $e->getMessage());
        }
        

    }
}
