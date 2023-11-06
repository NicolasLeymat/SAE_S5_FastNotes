<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Utilisateur
{
    use HasFactory;

    protected $fillable = array_merge(
        parent::fillable,
        [
            'isAdmin'
        ]
        );
}
