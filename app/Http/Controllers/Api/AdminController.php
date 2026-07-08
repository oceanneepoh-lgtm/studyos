<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ressource;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Actualite;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function stats()
    {
        return response()->json([
            'etudiants' => User::where('role', 'etudiant')->count(),
            'ressources' => Ressource::count(),
            'questions' => Question::count(),
            'quizzes' => Quiz::count(),
            'actualites' => Actualite::count(),
        ]);
    }

    public function etudiants()
    {
        return response()->json(
            User::where('role', 'etudiant')->with('etudiant')->orderBy('created_at', 'desc')->get()
        );
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Utilisateur supprime']);
    }
}
