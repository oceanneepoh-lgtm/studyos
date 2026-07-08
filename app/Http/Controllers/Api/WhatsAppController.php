<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeDocument;
use App\Services\AiService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'whatsapp_jid' => 'required|string',
        ]);

        $message = $request->message;
        $jid = $request->whatsapp_jid;

        $context = $this->searchKnowledge($message);

        $systemPrompt = "Tu es l'assistant virtuel WhatsApp de l'IUES/INSAM a Bafoussam, Cameroun.
Tu aides les etudiants dans leur parcours academique : revision, comprehension des cours, orientation, conseils.
Tu reponds en francais de maniere claire, concise et encourageante.
Tes reponses doivent etre adaptees au format WhatsApp (pas trop longues, bien structurees avec des emojis si pertinent).";

        if (!empty($context)) {
            $systemPrompt .= "\n\n--- BASE DE CONNAISSANCES INSAM ---\nVoici des documents de cours et ressources de l'INSAM. Utilise ces informations pour repondre de maniere precise. Cite les sources quand c'est pertinent.\n\n" . $context . "\n--- FIN DE LA BASE DE CONNAISSANCES ---";
        }

        try {
            $aiResponse = AiService::chat($systemPrompt, $message, 800);
        } catch (\Exception $e) {
            $aiResponse = 'Erreur de connexion avec l\'assistant IA. Veuillez reessayer.';
        }

        return response()->json([
            'reponse' => $aiResponse,
            'jid' => $jid,
        ]);
    }

    private function searchKnowledge(string $query): string
    {
        $documents = KnowledgeDocument::all();

        if ($documents->isEmpty()) {
            return '';
        }

        $stopWords = ['le', 'la', 'les', 'un', 'une', 'des', 'du', 'de', 'et', 'en', 'est', 'que', 'qui', 'dans', 'pour', 'pas', 'sur', 'ce', 'il', 'je', 'tu', 'nous', 'vous', 'ils', 'au', 'aux', 'avec', 'son', 'sa', 'ses', 'mon', 'ma', 'mes', 'comment', 'quoi', 'quel', 'quelle', 'faire', 'peut', 'moi', 'toi', 'lui', 'elle', 'ont', 'sont', 'etre', 'avoir', 'stp', 'svp', 'bonjour', 'salut', 'merci'];
        $words = preg_split('/[\s\-\_\?\!\.\,\;]+/', mb_strtolower($query));
        $keywords = array_filter($words, fn($w) => mb_strlen($w) > 2 && !in_array($w, $stopWords));

        if (empty($keywords)) $keywords = $words;

        $scored = [];
        foreach ($documents as $doc) {
            $score = 0;
            $contentLower = mb_strtolower($doc->contenu_texte);
            $titleLower = mb_strtolower($doc->titre);
            $matiereLower = mb_strtolower($doc->matiere ?? '');

            foreach ($keywords as $kw) {
                if (str_contains($titleLower, $kw)) $score += 10;
                if (str_contains($matiereLower, $kw)) $score += 8;
                $score += substr_count($contentLower, $kw) * 2;
            }

            if ($score > 0) {
                $scored[] = ['doc' => $doc, 'score' => $score];
            }
        }

        usort($scored, fn($a, $b) => $b['score'] - $a['score']);

        $contextParts = [];
        $totalLength = 0;
        $maxLength = 3000;

        foreach (array_slice($scored, 0, 3) as $item) {
            $doc = $item['doc'];
            $excerpt = mb_substr($doc->contenu_texte, 0, 1200);
            $header = "Document: {$doc->titre}";
            if ($doc->matiere) $header .= " | Matiere: {$doc->matiere}";

            $part = $header . "\n" . $excerpt;
            if ($totalLength + mb_strlen($part) > $maxLength) break;

            $contextParts[] = $part;
            $totalLength += mb_strlen($part);
        }

        return implode("\n\n", $contextParts);
    }
}
