<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    protected $fillable = ['question_id', 'contenu'];

    public function question() { return $this->belongsTo(Question::class); }
}
