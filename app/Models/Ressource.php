<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $table = 'ressource';
    protected $fillable = ["nom","code"];
    protected $primaryKey = "code";

    public function evaluations() {
        return $this->hasMany(Evaluation::class);
    }

    public function competence() {
        return $this->belongsToMany(Competence::class);
    }

    public function parcours() {
        return $this->belongsToMany(Parcours::class,"coefficient_ressource","code_ressource","id_parcours")->withPivot("coefficient");
    }
}
