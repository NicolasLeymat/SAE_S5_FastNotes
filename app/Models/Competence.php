<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = ["libelle"];

    protected $primaryKey = "code";
    protected $table = "competence";
    public $incrementing = false;


    public function ressources() {
        return $this->belongsToMany(Ressource::class, "coefficient_ressource", "code_competence", "code_ressource")->withPivot("coefficient");
    }

    use HasFactory;
}
