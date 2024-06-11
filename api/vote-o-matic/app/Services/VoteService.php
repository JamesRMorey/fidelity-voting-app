<?php

namespace App\Services;

use App\Jobs\StoreVoteJob;
use App\Models\User;

class VoteService
{
    public static function store( User $user, int $questionId, int $questionOptionId, string $ipAddress ): void
    {
        StoreVoteJob::dispatch( $user, $questionId, $questionOptionId, $ipAddress );

        $sessionVotedQuestionIds = session()->get('voted_question_ids', []);
        session()->put('voted_question_ids', [...$sessionVotedQuestionIds, $questionId]);
    }
}
