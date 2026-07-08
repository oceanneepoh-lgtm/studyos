<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['titre', 'matiere', 'chapitre', 'filiere', 'niveau'];

    public function questions() { return $this->hasMany(QuizQuestion::class); }
    public function reponses() { return $this->hasMany(QuizReponse::class); }
}
