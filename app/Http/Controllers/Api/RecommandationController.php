<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recommandation;
use App\Models\Ressource;
use App\Services\AiService;
use Illuminate\Http\Request;

class RecommandationController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Recommandation::where('user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
        );
    }

    public function generate(Request $request)
    {
        $user = $request->user();
        $etudiant = $user->etudiant;

        if (!$etudiant) {
            return response()->json(['message' => 'Profil etudiant requis'], 400);
        }

        $ressources = Ressource::where('filiere', $etudiant->filiere)
            ->orWhere('niveau', $etudiant->niveau)
            ->limit(5)->get();

        $ressourcesList = $ressources->map(fn($r) => "- {$r->titre} ({$r->type})")->join("\n");

        try {
            $message = AiService::chat(
                "Tu es un assistant academique de l'IUES/INSAM. Genere des recommandations personnalisees.",
                "Genere des recommandations personnalisees pour un etudiant en {$etudiant->filiere}, niveau {$etudiant->niveau}. Ressources disponibles:\n{$ressourcesList}\nDonne 3 recommandations courtes et utiles.",
                512
            );
        } catch (\Exception $e) {
            $message = "Recommandations basees sur votre profil ({$etudiant->filiere}, {$etudiant->niveau}) : consultez les ressources disponibles dans votre filiere.";
        }

        $reco = Recommandation::create([
            'user_id' => $user->id,
            'message' => $message,
        ]);

        return response()->json($reco);
    }
}
