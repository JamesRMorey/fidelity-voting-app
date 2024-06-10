<?php

namespace App\Services;

use App\Jobs\StoreVoteJob;
use App\Models\User;

class VoteService
{
    public function store( User $user, int $questionId, int $questionOptionId, string $ipAddress ): void
    {
        StoreVoteJob::dispatch( $user, $questionId, $questionOptionId, $ipAddress );
    }
}
