<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['user_id', 'contenu'];

    public function user() { return $this->belongsTo(User::class); }
    public function reponse() { return $this->hasOne(Reponse::class); }
}
