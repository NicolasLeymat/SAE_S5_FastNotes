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

    public function enseignements () {
        return $this->hasMany(Enseignement::class,"code");
    }
}
