<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;

    protected $table = "semestres";
    protected $fillable = [
        "libelle"
    ];

    public $timestamps = false;

    public $primaryKey = "id";

    public function ue(){
        return $this->hasMany(UE::class, 'code', 'id');
    }

    public function groupe(){
        return $this->hasMany(Groupe::class, 'id', 'id');
    }
}
