<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = array_merge(
        parent::fillable,
        [
            'identification',
            'id_groupe'
        ]
    );

    public function evaluations() {
        return $this->belongsToMany (Evaluation::class, 'note_evaluation', 'code_eleve', 'id_evaluation')
        ->withPivot("note");
    }

    public function groupe() {
        return $this->belongsTo(Groupe::class, "id_groupe", "id");
    }
}
