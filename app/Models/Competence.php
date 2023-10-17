<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = ["libelle"];

    protected $primaryKey = "id";

    public function ressources() {
        return $this->belongsToMany(Ressource::class)->withPivot("Coefficient");
    }

    public function parcours() {
        return $this->belongsToMany(Parcours::class);
    }

    use HasFactory;
}
