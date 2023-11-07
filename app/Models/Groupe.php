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

    protected $table = "groupes";

    public function eleve () {
        return $this->hasMany(Eleve::class,"id_groupe");
    }

    public function ressources() {
        return $this->belongsToMany(Ressource::class,"ressource_groupe","id_groupe","code_ressource");
    }

    public function ressource(){
        return $this->belongsToMany(ressource::class,"enseignements", "id_groupe", "code_ressource");
    }

    public function professeurs(){
        return $this->belongsToMany(ressource::class,"enseignements", "id_groupe", "code_prof");
    }
}
