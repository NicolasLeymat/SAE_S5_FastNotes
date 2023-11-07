<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Utilisateur
{
    use HasFactory;

    protected $fillable = array_merge(
        parent::fillable,
        [
            'isProf'
        ]
        );

    public function ressource () {
        return $this->belongsToMany(Ressource::class,"enseignements", "code_prof", "code_ressource");
    }

    public function groupe () {
        return $this->belongsToMany(Groupe::class,"enseignements", "code_prof", "id_groupe");
    }
}
