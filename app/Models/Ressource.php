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

    public $timestamps = false;

    public $incrementing = false;

    public function evaluations() {
        return $this->hasMany(Evaluation::class);
    }

    public function competences() {
        return $this->belongsToMany(Competence::class);
    }

    public function groupes() {
        return $this->belongsToMany(Groupe::class,"ressource_groupe","code_ressource","id_groupe");
    }
}
