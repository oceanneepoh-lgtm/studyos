<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizReponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::withCount('questions');
        if ($request->filiere) $query->where('filiere', $request->filiere);
        if ($request->niveau) $query->where('niveau', $request->niveau);

        return response()->json($query->orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'matiere' => 'required|string',
            'chapitre' => 'nullable|string',
            'filiere' => 'nullable|string',
            'niveau' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.bonne_reponse' => 'required|string',
        ]);

        $quiz = Quiz::create($request->only(['titre', 'matiere', 'chapitre', 'filiere', 'niveau']));

        foreach ($request->questions as $q) {
            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => $q['question'],
                'options' => $q['options'],
                'bonne_reponse' => $q['bonne_reponse'],
            ]);
        }

        return response()->json($quiz->load('questions'), 201);
    }

    public function show(Quiz $quiz)
    {
        return response()->json($quiz->load('questions'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'reponses' => 'required|array',
        ]);

        $questions = $quiz->questions;
        $score = 0;
        $total = $questions->count();

        foreach ($questions as $q) {
            $userAnswer = $request->reponses[$q->id] ?? null;
            if ($userAnswer === $q->bonne_reponse) {
                $score++;
            }
        }

        $result = QuizReponse::create([
            'user_id' => $request->user()->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total' => $total,
            'reponses' => $request->reponses,
        ]);

        return response()->json([
            'score' => $score,
            'total' => $total,
            'pourcentage' => round(($score / max($total, 1)) * 100),
            'result' => $result,
        ]);
    }

    public function mesResultats(Request $request)
    {
        $resultats = QuizReponse::where('user_id', $request->user()->id)
            ->with('quiz')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($resultats);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return response()->json(['message' => 'Quiz supprime']);
    }
}
