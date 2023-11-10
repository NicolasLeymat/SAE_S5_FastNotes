<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UE extends Model
{
    use HasFactory;

    protected $table = "ue";
    protected $fillable = ["code", "libele"];

    public $primaryKey = "code";

    public $timestamps = false;

    public $incrementing = false;

    public function semestre(){
        return $this->belongsTo(Semestre::class, 'id', 'code');
    }

    public function ressources() {
        return $this->belongsToMany(Ressource::class, "coefficient_ue", "code_ue", "code_ressource")->withPivot("coefficient");
    }

    public function competence(){
        return $this->hasOne(Competence::class, "code", "code");
    }

}
