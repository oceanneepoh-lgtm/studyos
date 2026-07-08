<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['nom', 'prenom', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    public function etudiant() { return $this->hasOne(Etudiant::class); }
    public function questions() { return $this->hasMany(Question::class); }
    public function recommandations() { return $this->hasMany(Recommandation::class); }
    public function quizReponses() { return $this->hasMany(QuizReponse::class); }

    public function isAdmin() { return $this->role === 'admin'; }
}
