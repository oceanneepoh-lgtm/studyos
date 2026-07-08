<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeDocument;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index()
    {
        return response()->json(
            KnowledgeDocument::orderBy('created_at', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'fichier' => 'required|file|max:10240',
            'filiere' => 'nullable|string',
            'niveau' => 'nullable|string',
            'matiere' => 'nullable|string',
        ]);

        $file = $request->file('fichier');
        $path = $file->store('knowledge', 'public');
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());

        // Extract text content from the file
        $texte = '';
        $fullPath = storage_path('app/public/' . $path);

        if ($extension === 'txt') {
            $texte = file_get_contents($fullPath);
        } elseif ($extension === 'pdf') {
            $texte = $this->extractPdfText($fullPath);
        } elseif (in_array($extension, ['doc', 'docx'])) {
            $texte = $this->extractDocxText($fullPath);
        } elseif (in_array($extension, ['ppt', 'pptx'])) {
            $texte = $this->extractPptxText($fullPath);
        } else {
            $texte = file_get_contents($fullPath);
        }

        // If extraction failed, store notice
        if (empty(trim($texte))) {
            $texte = "[Contenu non extractible automatiquement pour le fichier: {$originalName}]";
        }

        // Allow admin to also paste text content directly
        if ($request->has('contenu_additionnel') && $request->contenu_additionnel) {
            $texte .= "\n\n" . $request->contenu_additionnel;
        }

        $doc = KnowledgeDocument::create([
            'titre' => $request->titre,
            'filiere' => $request->filiere,
            'niveau' => $request->niveau,
            'matiere' => $request->matiere,
            'fichier_path' => $path,
            'fichier_nom' => $originalName,
            'contenu_texte' => $texte,
        ]);

        return response()->json($doc, 201);
    }

    public function destroy(KnowledgeDocument $document)
    {
        if ($document->fichier_path) {
            \Storage::disk('public')->delete($document->fichier_path);
        }
        $document->delete();
        return response()->json(['message' => 'Document supprime']);
    }

    private function extractPdfText(string $path): string
    {
        // Use pdftotext if available (common on most systems)
        $output = '';
        $cmd = 'pdftotext ' . escapeshellarg($path) . ' - 2>/dev/null';
        $output = shell_exec($cmd);

        if (!empty(trim($output))) {
            return $output;
        }

        // Fallback: basic PHP PDF text extraction
        $content = file_get_contents($path);
        // Extract text between stream/endstream
        $texts = [];
        if (preg_match_all('/stream\s*(.+?)\s*endstream/s', $content, $matches)) {
            foreach ($matches[1] as $match) {
                $decoded = @gzuncompress($match);
                if ($decoded) {
                    if (preg_match_all('/\(([^)]+)\)/', $decoded, $textMatches)) {
                        $texts[] = implode(' ', $textMatches[1]);
                    }
                    if (preg_match_all('/\[([^\]]+)\]\s*TJ/s', $decoded, $tjMatches)) {
                        foreach ($tjMatches[1] as $tj) {
                            if (preg_match_all('/\(([^)]+)\)/', $tj, $tjText)) {
                                $texts[] = implode('', $tjText[1]);
                            }
                        }
                    }
                }
            }
        }
        return implode("\n", $texts);
    }

    private function extractDocxText(string $path): string
    {
        $text = '';
        $zip = new \ZipArchive();
        if ($zip->open($path) === true) {
            $xml = $zip->getFromName('word/document.xml');
            if ($xml) {
                $text = strip_tags(str_replace('<', ' <', $xml));
                $text = preg_replace('/\s+/', ' ', $text);
            }
            $zip->close();
        }
        return trim($text);
    }

    private function extractPptxText(string $path): string
    {
        $texts = [];
        $zip = new \ZipArchive();
        if ($zip->open($path) === true) {
            for ($i = 1; $i <= 100; $i++) {
                $xml = $zip->getFromName("ppt/slides/slide{$i}.xml");
                if (!$xml) break;
                $slideText = strip_tags(str_replace('<', ' <', $xml));
                $slideText = preg_replace('/\s+/', ' ', $slideText);
                if (trim($slideText)) {
                    $texts[] = "--- Slide {$i} ---\n" . trim($slideText);
                }
            }
            $zip->close();
        }
        return implode("\n\n", $texts);
    }
}
