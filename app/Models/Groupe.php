<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["libelle","semestre","annee", "parcours"];

    protected $id = "id";

    protected $table = "groupe";

    public function utilisateurs () {
        return $this->hasMany(Utilisateur::class,"id_groupe");
    }

    public function ressources() {
        return $this->belongsToMany(Groupe::class,"ressource_groupe","code_ressource","id_groupe");
    }
}
