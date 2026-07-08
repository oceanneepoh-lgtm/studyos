<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = ['user_id', 'matricule', 'niveau', 'filiere', 'interets', 'competences'];

    public function user() { return $this->belongsTo(User::class); }
}
