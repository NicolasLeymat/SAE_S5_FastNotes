<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ["libelle","coefficient","type", "ressource_id"];

    protected $primaryKey = "id";

    public function utilisateurs () {
        return $this->hasMany(Utilisateur::class)->withPivot('note');
    }

    public function ressource () {
        return $this->belongsTo(Ressource::class);
    }
}
