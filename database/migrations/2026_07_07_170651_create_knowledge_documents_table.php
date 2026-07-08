<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_documents', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('filiere')->nullable();
            $table->string('niveau')->nullable();
            $table->string('matiere')->nullable();
            $table->string('fichier_path')->nullable();
            $table->string('fichier_nom');
            $table->longText('contenu_texte');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_documents');
    }
};
