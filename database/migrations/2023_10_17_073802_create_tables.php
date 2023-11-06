<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {       
        Schema::create('groupe', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('semestre');
            $table->year('annee');
            $table->string('parcours');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->string('identification');
            $table->string('password');
            $table->string('email');
            $table->string('nom');
            $table->string('prenom');
            $table->boolean('isProf');
            $table->boolean('isAdmin');
            $table->unsignedBigInteger('id_groupe');
            $table->foreign('id_groupe')->references('id')->on('groupe');
        });

        Schema::create('competence', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->string('libelle');
        });

        Schema::create('ressource', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->string('libelle');
        });

        Schema::create('evaluation', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->float('coefficient');
            $table->string('type');
            $table->string('code_ressource');
            $table->foreign('code_ressource')->references('code')->on('ressource');
        });

        Schema::create('note_evaluation', function (Blueprint $table) {
            $table->string('note');
            $table->unsignedBigInteger('id_evaluation');
            $table->string('code_eleve');
            $table->foreign('code_eleve')->references('code')->on('users');
            $table->foreign('id_evaluation')->references('id')->on('evaluation');
            $table->primary(['id_evaluation', 'code_eleve']);
        });

        Schema::create('coefficient_ressource', function (Blueprint $table) {
            $table->string('code_ressource');
            $table->string('code_competence');
            $table->foreign('code_ressource')->references('code')->on('ressource');
            $table->foreign('code_competence')->references('code')->on('competence');
            $table->float('coefficient');
            $table->primary(['code_competence', 'code_ressource']);
        });

        Schema::create('ressource_groupe', function (Blueprint $table) {
            $table->unsignedBigInteger('id_groupe');
            $table->string('code_ressource');
            $table->foreign('code_ressource')->references('code')->on('ressource');
            $table->foreign('id_groupe')->references('id')->on('groupe');
            $table->primary(['id_groupe', 'code_ressource']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_evaluation');
        Schema::dropIfExists('coefficient_ressource');
        Schema::dropIfExists('competence');
        Schema::dropIfExists('users');
        Schema::dropIfExists('evaluation');
        Schema::dropIfExists('groupe');
        Schema::dropIfExists('ressource_groupe');
        Schema::dropIfExists('ressource');
    }
};
