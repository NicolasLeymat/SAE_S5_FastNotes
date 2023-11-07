<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $table = 'ressources';
    protected $fillable = ["nom","code"];
    protected $primaryKey = "code";

    public $timestamps = false;

    public $incrementing = false;

    
    public function evaluations() {
        return $this->hasMany(Evaluation::class, 'code_ressource');
    }

    public function competences() {
        return $this->belongsToMany(Competence::class, "coefficient_ressource", "code_ressource", "code_competence")->withPivot("coefficient");
    }

    public function groupes() {
        return $this->belongsToMany(Groupe::class,"ressource_groupe","code_ressource","id_groupe");
    }

    public function groupe() {
        return $this->belongsToMany(Groupe::class,"enseignements", "code_ressource", "id_groupe");
    }

    public function professeur() {
        return $this->belongsToMany(Groupe::class,"enseignements", "code_ressource", "code_prof");
    }
}