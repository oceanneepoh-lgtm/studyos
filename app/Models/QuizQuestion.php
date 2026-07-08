<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['quiz_id', 'question', 'options', 'bonne_reponse'];
    protected $casts = ['options' => 'array'];

    public function quiz() { return $this->belongsTo(Quiz::class); }
}
