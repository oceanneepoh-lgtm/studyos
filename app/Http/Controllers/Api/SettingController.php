<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\AiService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(AiService::getProviderInfo());
    }

    public function update(Request $request)
    {
        $request->validate([
            'ai_provider' => 'required|in:claude,gemini',
        ]);

        Setting::set('ai_provider', $request->ai_provider);

        if ($request->filled('anthropic_api_key')) {
            Setting::set('anthropic_api_key', $request->anthropic_api_key);
        }

        if ($request->filled('gemini_api_key')) {
            Setting::set('gemini_api_key', $request->gemini_api_key);
        }

        if ($request->filled('claude_model')) {
            Setting::set('claude_model', $request->claude_model);
        }

        if ($request->filled('gemini_model')) {
            Setting::set('gemini_model', $request->gemini_model);
        }

        return response()->json(['message' => 'Configuration sauvegardee', 'settings' => AiService::getProviderInfo()]);
    }

    public function testConnection(Request $request)
    {
        $provider = Setting::get('ai_provider', 'claude');

        try {
            $response = AiService::chat(
                'Tu es un assistant de test. Reponds en une phrase courte.',
                'Dis bonjour en francais.',
                100
            );

            return response()->json([
                'success' => !str_starts_with($response, 'Erreur'),
                'provider' => $provider,
                'response' => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'provider' => $provider,
                'response' => 'Erreur: ' . $e->getMessage(),
            ]);
        }
    }
}
