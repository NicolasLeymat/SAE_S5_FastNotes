<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = ["libelle"];

    protected $primaryKey = "id";
    protected $table = "competence";

    public function ressources() {
        return $this->belongsToMany(Ressource::class, "coefficient_ressource", "id_competence", "code_ressource")->withPivot("Coefficient");
    }

    public function parcours() {
        return $this->belongsToMany(Parcours::class);
    }

    use HasFactory;
}
