<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ["id","libelle"];

    protected $id = "id";

    protected $table = "Parcours";


    public function groupes (){
        return $this->hasMany(Groupe::class, "id", "id_groupe");
    }

    public function semestre(){
        return $this->hasOne(Semestre::class, "id", "id_semestre");
    }

}
