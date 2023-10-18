<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;

    protected $fillable = ["nom","code"];

    protected $primaryKey = "id";

    public function groupe() {
        return $this->hasMany(Groupe::class);
    }

    public function ressources() {
        return $this->belongsToMany(Ressource::class);
    }

    public function competence() {
        return $this->belongsToMany(Competence::class);
    }
}
