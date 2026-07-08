<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeDocument extends Model
{
    protected $fillable = ['titre', 'filiere', 'niveau', 'matiere', 'fichier_path', 'fichier_nom', 'contenu_texte'];
}
