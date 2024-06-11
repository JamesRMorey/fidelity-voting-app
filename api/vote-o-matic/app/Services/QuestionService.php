<?php

namespace App\Services;

use App\Models\Question;
use App\Models\User;

class QuestionService
{
    public static function randomForUser( User $user ): Question
    {
        $sessionVotedQuestionIds = session()->get('voted_question_ids', []);

        return Question::with(['options'])
            ->whereNotIn('id', $user->votes->pluck('question_id')->toArray())
            ->whereNotIn('id', $sessionVotedQuestionIds)
            ->inRandomOrder()
            ->firstOrFail();
    }
}
