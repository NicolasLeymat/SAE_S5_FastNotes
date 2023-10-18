<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = ["libelle","semestre","annee", "id_parcours"];

    protected $id = "id";

    public function parcours () {
        return $this->belongsTo(Parcours::class,"id_parcours");
    }

    public function utilisateurs () {
        return $this->hasMany(Utilisateur::class);
    }
}
