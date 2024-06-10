<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserHasNotVoted
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionVotedQuestionIds = session()->get('voted_question_ids', []);

        if (in_array($request->route('question')->id, $sessionVotedQuestionIds)) {
            return response()->json(['message' => 'You have already voted on this question'], 403);
        }

        $user = auth()->user();
        $question =  $request->route('question');

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        if ($user->hasVoted($question)) {
            return response()->json(['message' => 'You have already voted on this question'], 403);
        }

        return $next($request);
    }
}
