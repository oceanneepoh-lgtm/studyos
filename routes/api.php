<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\RessourceController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ActualiteController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\RecommandationController;
use App\Http\Controllers\Api\KnowledgeController;
use App\Http\Controllers\Api\WhatsAppController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Support\Facades\Route;

// Auth publique
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Actualites publiques
Route::get('/actualites', [ActualiteController::class, 'index']);

// WhatsApp bot (appele par le serveur Node.js Baileys)
Route::post('/whatsapp/chat', [WhatsAppController::class, 'chat']);

// Routes protegees
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Chat IA
    Route::post('/chat', [ChatController::class, 'ask']);
    Route::get('/chat/history', [ChatController::class, 'history']);

    // Ressources
    Route::get('/ressources', [RessourceController::class, 'index']);
    Route::get('/ressources/{ressource}', [RessourceController::class, 'show']);
    Route::get('/ressources/{ressource}/download', [RessourceController::class, 'download']);

    // Quiz
    Route::get('/quizzes', [QuizController::class, 'index']);
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show']);
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit']);
    Route::get('/mes-resultats', [QuizController::class, 'mesResultats']);

    // Recommandations
    Route::get('/recommandations', [RecommandationController::class, 'index']);
    Route::post('/recommandations/generate', [RecommandationController::class, 'generate']);

    // Admin
    Route::middleware('can:admin')->prefix('admin')->group(function () {
        Route::get('/stats', [AdminController::class, 'stats']);
        Route::get('/etudiants', [AdminController::class, 'etudiants']);
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);

        Route::post('/ressources', [RessourceController::class, 'store']);
        Route::delete('/ressources/{ressource}', [RessourceController::class, 'destroy']);

        Route::post('/quizzes', [QuizController::class, 'store']);
        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy']);

        Route::post('/actualites', [ActualiteController::class, 'store']);
        Route::delete('/actualites/{actualite}', [ActualiteController::class, 'destroy']);

        Route::get('/knowledge', [KnowledgeController::class, 'index']);
        Route::post('/knowledge', [KnowledgeController::class, 'store']);
        Route::delete('/knowledge/{document}', [KnowledgeController::class, 'destroy']);

        Route::get('/settings', [SettingController::class, 'index']);
        Route::put('/settings', [SettingController::class, 'update']);
        Route::post('/settings/test', [SettingController::class, 'testConnection']);
    });
});
