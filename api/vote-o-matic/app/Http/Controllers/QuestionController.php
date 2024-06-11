<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Services\QuestionService;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    public function random(): JsonResponse
    {
        try {
            $user = auth()->user();

            $question = QuestionService::randomForUser($user);

            return response()->json(new QuestionResource($question), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'You have voted on all our questions, we don\'t want any more of your opinions!'], 404);
        }
    }
}
