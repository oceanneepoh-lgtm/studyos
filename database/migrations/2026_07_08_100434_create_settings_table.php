<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['key' => 'ai_provider', 'value' => 'claude', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'anthropic_api_key', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'gemini_api_key', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'claude_model', 'value' => 'claude-haiku-4-5-20251001', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'gemini_model', 'value' => 'gemini-2.0-flash', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
