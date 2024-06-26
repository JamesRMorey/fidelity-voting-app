<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Question;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;

class VoteController extends Controller
{
    public function store( VoteRequest $request, Question $question ): JsonResponse
    {
        try {
            $user = auth()->user();

            VoteService::store( $user, $question->id, $request->question_option_id, $request->ip() );

            return response()->json(['message' => 'Vote stored successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Could not create vote'], 500);
        }
    }
}
