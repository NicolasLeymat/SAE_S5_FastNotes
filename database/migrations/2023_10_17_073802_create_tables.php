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
        Schema::create('parcours', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('code');
        });

        Schema::create('groupe', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('semestre');
            $table->year('annee');
            $table->unsignedBigInteger('id_parcours');
            $table->foreign('id_parcours')->references('id')->on('parcours');
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
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('email_verified_at');
            $table->timestamp('email_updated_at');
        });

        Schema::create('competence', function (Blueprint $table) {
            $table->id();
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
<<<<<<< HEAD
            $table->string('coefficient');
            $table->unsignedBigInteger('id_competence');
=======
            $table->double('coefficient');
            $table->char('code_competence');
>>>>>>> ac03cf677cd9a27ee0611f0f757ab8ad0c1dd033
            $table->unsignedBigInteger('id_parcours');
            $table->string('code_ressource');
            $table->foreign('code_ressource')->references('code')->on('ressource');
            $table->foreign('id_competence')->references('id')->on('competence');
            $table->foreign('id_parcours')->references('id')->on('parcours');
            $table->primary(['id_competence', 'id_parcours', 'code_ressource']);
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
        Schema::dropIfExists('parcours');
        Schema::dropIfExists('ressource');
    }
};
