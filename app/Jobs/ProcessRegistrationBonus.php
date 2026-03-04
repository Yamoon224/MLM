<?php

namespace App\Jobs;

use App\Services\BonusService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessRegistrationBonus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $sponsorId,
        public string $newUserId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(BonusService $bonusService): void
    {
        $bonusService->handleRegistrationBonusById(
            $this->sponsorId,
            $this->newUserId
        );
    }
}
