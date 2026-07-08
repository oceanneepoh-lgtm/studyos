<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\KnowledgeDocument;
use App\Services\AiService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $user = $request->user();
        $etudiant = $user->etudiant;

        $context = $this->searchKnowledge($request->message, $etudiant);

        $systemPrompt = "Tu es un assistant virtuel intelligent pour l'accompagnement academique des etudiants de l'IUES/INSAM a Bafoussam, Cameroun.
Tu aides les etudiants dans leur parcours academique : orientation, revision, comprehension des cours, conseils d'organisation.
Tu reponds en francais de maniere claire, pedagogique et encourageante.";

        if ($etudiant) {
            $systemPrompt .= "\nL'etudiant est en {$etudiant->filiere}, niveau {$etudiant->niveau}.";
        }

        if (!empty($context)) {
            $systemPrompt .= "\n\n--- BASE DE CONNAISSANCES INSAM ---\nVoici des documents de cours et ressources disponibles a l'INSAM. Utilise ces informations pour repondre de maniere precise et contextuelle. Cite les sources quand c'est pertinent.\n\n" . $context . "\n--- FIN DE LA BASE DE CONNAISSANCES ---";
        }

        $question = Question::create([
            'user_id' => $user->id,
            'contenu' => $request->message,
        ]);

        try {
            $aiResponse = AiService::chat($systemPrompt, $request->message, 1024);
        } catch (\Exception $e) {
            $aiResponse = 'Erreur de connexion avec l\'assistant IA. Veuillez reessayer.';
        }

        $reponse = Reponse::create([
            'question_id' => $question->id,
            'contenu' => $aiResponse,
        ]);

        return response()->json([
            'question' => $question,
            'reponse' => $reponse,
        ]);
    }

    public function history(Request $request)
    {
        $questions = Question::where('user_id', $request->user()->id)
            ->with('reponse')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json($questions);
    }

    private function searchKnowledge(string $query, $etudiant = null): string
    {
        $documents = KnowledgeDocument::all();

        if ($documents->isEmpty()) {
            return '';
        }

        $stopWords = ['le', 'la', 'les', 'un', 'une', 'des', 'du', 'de', 'et', 'en', 'est', 'que', 'qui', 'dans', 'pour', 'pas', 'sur', 'ce', 'il', 'je', 'tu', 'nous', 'vous', 'ils', 'au', 'aux', 'avec', 'son', 'sa', 'ses', 'mon', 'ma', 'mes', 'comment', 'quoi', 'quel', 'quelle', 'quels', 'quelles', 'faire', 'peut', 'moi', 'toi', 'lui', 'elle', 'ont', 'sont', 'etre', 'avoir'];
        $words = preg_split('/[\s\-\_\?\!\.\,\;]+/', mb_strtolower($query));
        $keywords = array_filter($words, fn($w) => mb_strlen($w) > 2 && !in_array($w, $stopWords));

        if (empty($keywords)) {
            $keywords = $words;
        }

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

            if ($etudiant) {
                if ($doc->filiere && mb_strtolower($doc->filiere) === mb_strtolower($etudiant->filiere)) $score += 5;
                if ($doc->niveau && mb_strtolower($doc->niveau) === mb_strtolower($etudiant->niveau)) $score += 3;
            }

            if ($score > 0) {
                $scored[] = ['doc' => $doc, 'score' => $score];
            }
        }

        usort($scored, fn($a, $b) => $b['score'] - $a['score']);

        $contextParts = [];
        $totalLength = 0;
        $maxLength = 4000;

        foreach (array_slice($scored, 0, 3) as $item) {
            $doc = $item['doc'];
            $excerpt = mb_substr($doc->contenu_texte, 0, 1500);
            $header = "Document: {$doc->titre}";
            if ($doc->matiere) $header .= " | Matiere: {$doc->matiere}";
            if ($doc->filiere) $header .= " | Filiere: {$doc->filiere}";

            $part = $header . "\n" . $excerpt;
            if ($totalLength + mb_strlen($part) > $maxLength) break;

            $contextParts[] = $part;
            $totalLength += mb_strlen($part);
        }

        return implode("\n\n", $contextParts);
    }
}
