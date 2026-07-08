<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class AiService
{
    public static function chat(string $systemPrompt, string $userMessage, int $maxTokens = 1024): string
    {
        $provider = Setting::get('ai_provider', 'claude');

        if ($provider === 'gemini') {
            return static::callGemini($systemPrompt, $userMessage, $maxTokens);
        }

        return static::callClaude($systemPrompt, $userMessage, $maxTokens);
    }

    private static function callClaude(string $systemPrompt, string $userMessage, int $maxTokens): string
    {
        $apiKey = Setting::get('anthropic_api_key') ?: config('services.anthropic.api_key');

        if (!$apiKey) {
            return 'Erreur: Cle API Claude non configuree. Contactez l\'administrateur.';
        }

        $model = Setting::get('claude_model', 'claude-haiku-4-5-20251001');

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'anthropic-version' => '2023-06-01',
            'Content-Type' => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model' => $model,
            'max_tokens' => $maxTokens,
            'system' => $systemPrompt,
            'messages' => [
                ['role' => 'user', 'content' => $userMessage],
            ],
        ]);

        if (!$response->successful()) {
            return 'Erreur API Claude: ' . ($response->json()['error']['message'] ?? 'Erreur inconnue');
        }

        return $response->json()['content'][0]['text'] ?? 'Desole, je n\'ai pas pu generer une reponse.';
    }

    private static function callGemini(string $systemPrompt, string $userMessage, int $maxTokens): string
    {
        $apiKey = Setting::get('gemini_api_key');

        if (!$apiKey) {
            return 'Erreur: Cle API Gemini non configuree. Contactez l\'administrateur.';
        }

        $model = Setting::get('gemini_model', 'gemini-2.0-flash');

        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]],
            ],
            'contents' => [
                [
                    'parts' => [['text' => $userMessage]],
                ],
            ],
            'generationConfig' => [
                'maxOutputTokens' => $maxTokens,
                'temperature' => 0.7,
            ],
        ]);

        if (!$response->successful()) {
            return 'Erreur API Gemini: ' . ($response->json()['error']['message'] ?? 'Erreur inconnue');
        }

        return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Desole, je n\'ai pas pu generer une reponse.';
    }

    public static function getProviderInfo(): array
    {
        $provider = Setting::get('ai_provider', 'claude');
        return [
            'provider' => $provider,
            'anthropic_api_key' => Setting::get('anthropic_api_key') ? '****' . substr(Setting::get('anthropic_api_key'), -8) : null,
            'gemini_api_key' => Setting::get('gemini_api_key') ? '****' . substr(Setting::get('gemini_api_key'), -8) : null,
            'claude_model' => Setting::get('claude_model', 'claude-haiku-4-5-20251001'),
            'gemini_model' => Setting::get('gemini_model', 'gemini-2.0-flash'),
        ];
    }
}
