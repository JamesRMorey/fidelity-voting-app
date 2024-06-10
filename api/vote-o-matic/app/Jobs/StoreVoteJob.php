<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\IPInfoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreVoteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected int $questionId;
    protected int $questionOptionId;
    protected string $ipAddress;

    public function __construct( User $user, int $questionId, int $questionOptionId, string $ipAddress )
    {
        $this->user = $user;
        $this->questionId = $questionId;
        $this->questionOptionId = $questionOptionId;
        $this->ipAddress = $ipAddress;
    }

    public function handle(): void
    {
        $ipLocation = (new IPInfoService())->getIPLocation( $this->ipAddress );

        $this->user->votes()->create([
            'question_id' => $this->questionId,
            'question_option_id' => $this->questionOptionId,
            'ip_address' => $this->ipAddress,
            'estimated_location' => $ipLocation ? json_encode($ipLocation) : null
        ]);
    }
}
