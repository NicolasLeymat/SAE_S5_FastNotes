<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    use HasFactory;
    protected $table = "Annee";
    protected $fillable = [
        "id","Anne_Debut", "Annee_Fin"
    ];
    public $timestamps = false;
    public $primaryKey = "id";
    public $incrementing = false;

    public function ue(){
        return $this->hasMany(Semestre::class, 'id', 'id');
    }
}
