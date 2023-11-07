<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $id = "id";

    protected $table = "enseignement";

    public function professeur () {
        return $this->hasOne(Professeur::class,"code_utilisateur","code");
    }

    public function ressource () {
        return $this->hasOne(Ressource::class,"code_ressource","code");
    }

    public function groupe () {
        return $this->hasOne(Groupe::class,"id_groupe","id");
    }
}