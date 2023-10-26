<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $table = 'ressource';
    protected $fillable = ["nom","code"];
    protected $primaryKey = "code";
    public $incrementing = false;


    public $incrementing = false;

    public function evaluations() {
        return $this->hasMany(Evaluation::class);
    }

<<<<<<< HEAD
    public function competence() {
        return $this->belongsToMany(Competence::class, "coefficient_ressource", "code_ressource", "id_competence")->withPivot("coefficient");
=======
    public function competences() {
        return $this->belongsToMany(Competence::class);
>>>>>>> bb1365a6bb47b0bc7e294a4ab516b90b1810a250
    }

    public function groupes() {
        return $this->belongsToMany(Groupe::class,"ressource_groupe","code_ressource","id_groupe");
    }
}
