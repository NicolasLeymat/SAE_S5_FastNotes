<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["libelle","semestre","annee", "id_parcours"];

    protected $id = "id";

    protected $table = "groupe";

    public function parcours () {
        return $this->belongsTo(Parcours::class,"id_parcours","id");
    }

    public function utilisateurs () {
        return $this->hasMany(Utilisateur::class,"id_groupe");
    }
}
