<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    protected $fillable = ['titre', 'description', 'date_publication', 'user_id'];

    public function user() { return $this->belongsTo(User::class); }
}
