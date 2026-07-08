<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('matiere');
            $table->string('chapitre')->nullable();
            $table->string('filiere')->nullable();
            $table->string('niveau')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('quizzes'); }
};
