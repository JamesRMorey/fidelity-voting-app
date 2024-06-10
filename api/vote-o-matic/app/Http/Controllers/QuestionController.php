<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    public function random(): JsonResponse
    {
        try {
            $user = auth()->user();

            $question = Question::with(['options'])
                ->whereNotIn('id', $user->votes->pluck('question_id')->toArray())
                ->inRandomOrder()
                ->firstOrFail();

            return response()->json(new QuestionResource($question), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'You have voted on all our questions, we don\'t want any more of your opinions!'], 404);
        }
    }
}
