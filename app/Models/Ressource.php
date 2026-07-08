<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    protected $fillable = ['titre', 'description', 'type', 'filiere', 'niveau', 'fichier', 'telechargements', 'user_id'];

    public function user() { return $this->belongsTo(User::class); }
}
