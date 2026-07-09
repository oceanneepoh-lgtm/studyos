<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RessourceController extends Controller
{
    public function index(Request $request)
    {
        $query = Ressource::query();

        if ($request->filiere) $query->where('filiere', $request->filiere);
        if ($request->niveau) $query->where('niveau', $request->niveau);
        if ($request->type) $query->where('type', $request->type);
        if ($request->search) $query->where('titre', 'like', '%'.$request->search.'%');

        return response()->json($query->orderBy('created_at', 'desc')->paginate(20));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'filiere' => 'nullable|string',
            'niveau' => 'nullable|string',
            'fichier' => 'nullable|file|max:10240',
        ]);

        $data = $request->only(['titre', 'description', 'type', 'filiere', 'niveau']);
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('fichier')) {
            $data['fichier'] = $request->file('fichier')->store('ressources', 'public');
        }

        $ressource = Ressource::create($data);
        return response()->json($ressource, 201);
    }

    public function show(Ressource $ressource)
    {
        return response()->json($ressource);
    }

    public function download(Ressource $ressource)
    {
        if (!$ressource->fichier) {
            return response()->json(['message' => 'Aucun fichier'], 404);
        }

        $ressource->increment('telechargements');
        return Storage::disk('public')->download($ressource->fichier);
    }

    public function destroy(Ressource $ressource)
    {
        if ($ressource->fichier) {
            Storage::disk('public')->delete($ressource->fichier);
        }
        $ressource->delete();
        return response()->json(['message' => 'Ressource supprimee']);
    }
}
