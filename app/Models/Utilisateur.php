<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = "code";
    protected $fillable = [
        'code',
        'identification',
        'password',
        'email',
        'nom',
        'prenom',
        'isProf',
        'isAdmin',
        'id_groupe'
    ];

    protected $table = "users";

    public function evaluations() {
        return $this->belongsToMany(Evaluation::class, 'note_evaluation', 'code_eleve', 'id_evaluation')->withPivot("note");
    }

    public function groupe() {
        return $this->belongsTo(Groupe::class, "id_groupe");
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
