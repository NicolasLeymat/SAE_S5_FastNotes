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

<<<<<<< HEAD
=======
    public $timestamps = false;

    public function ressources() {
        return $this->belongsToMany(Ressource::class)->withPivot("Coefficient");
    }
>>>>>>> f4eb9a17e3db4a6b78e0b8fbcbb9034affd20bf8

    public function ressources() {
        return $this->belongsToMany(Ressource::class, "coefficient_ressource", "code_competence", "code_ressource")->withPivot("coefficient");
    }

    use HasFactory;
}
