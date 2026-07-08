<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;

class ActualiteController extends Controller
{
    public function index()
    {
        return response()->json(
            Actualite::orderBy('created_at', 'desc')->paginate(20)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_publication' => 'nullable|date',
        ]);

        $actualite = Actualite::create([
            ...$request->only(['titre', 'description', 'date_publication']),
            'user_id' => $request->user()->id,
        ]);

        return response()->json($actualite, 201);
    }

    public function destroy(Actualite $actualite)
    {
        $actualite->delete();
        return response()->json(['message' => 'Actualite supprimee']);
    }
}
