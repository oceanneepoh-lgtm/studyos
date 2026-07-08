<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ressources', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->enum('type', ['cours', 'examen', 'td', 'tp', 'fiche_revision', 'autre'])->default('cours');
            $table->string('filiere')->nullable();
            $table->string('niveau')->nullable();
            $table->string('fichier')->nullable();
            $table->integer('telechargements')->default(0);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ressources'); }
};
