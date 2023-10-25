<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["nom","code"];

    protected $primaryKey = "id";

    public function groupes() {
        return $this->hasMany(Groupe::class,"id");
    }

    public function ressources() {
        return $this->belongsToMany(Ressource::class);
    }

    public function competence() {
        return $this->belongsToMany(Competence::class);
    }
}
