<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('matricule')->unique();
            $table->string('niveau');
            $table->string('filiere');
            $table->text('interets')->nullable();
            $table->text('competences')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('etudiants'); }
};
