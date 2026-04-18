<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeactivateExpiredAccounts extends Command
{
    protected $signature   = 'app:deactivate-expired-accounts';
    protected $description = 'Deactivate accounts whose expiry date has passed';

    public function handle(): int
    {
        $count = User::expired()->update(['is_active' => false]);

        $this->info("Deactivated {$count} expired account(s).");

        return self::SUCCESS;
    }
}
