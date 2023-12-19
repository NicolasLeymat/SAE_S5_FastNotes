<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ["libelle","coefficient","type"];

    public $timestamps = false;
    protected $table = "evaluations";

    public function utilisateurs () {
        return $this->belongsToMany(Utilisateur::class, 'note_evaluation', 'id_evaluation', 'code_eleve')
        ->withPivot('note');
    }

    public function ressource () {
        return $this->belongsTo(Ressource::class, "code_ressource");
    }
}
