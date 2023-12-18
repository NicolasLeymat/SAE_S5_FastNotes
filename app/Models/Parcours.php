<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ["id_parcour"];

    protected $id = "id_parcour";

    protected $table = "Parcours";


    public function groupes (){
        return $this->hasMany(Groupe::class, "id_parcour", "id_groupe");
    }

    public function semestre(){
        return $this->hasOne(Semestre::class, "id_parcour", "id_semestre");
    }

}
