<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Utilisateur
{
    use HasFactory;

    protected $table = 'admins';
    protected $fillable =
        [
            'isAdmin'
        ]
        ;
    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class,"code","code");
    }
}
