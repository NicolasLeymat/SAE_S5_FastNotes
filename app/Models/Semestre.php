<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;
    protected $table = "semestres";
    protected $fillable = [
        "id","libelle"
    ];
    public $timestamps = false;
    public $primaryKey = "id_semestre";
    public $incrementing = false;

    public function ue(){
        return $this->hasMany(UE::class, 'code', 'id');
    }

    public function groupe(){
        return $this->hasMany(Groupe::class, 'id', 'id');
    }

    public function parcours(){
        return $this->hasMany(Parcours::class, "id", "id");
    }

    public function annee(){
        return $this->hasMany(Annee::class, "id", "id");
    }
}
