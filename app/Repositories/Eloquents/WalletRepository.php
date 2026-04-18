<?php

namespace App\Repositories\Eloquents;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\WalletRepositoryInterface;

class WalletRepository implements WalletRepositoryInterface
{
    public function findByUser(string $userId)
    {
        return Wallet::where('user_id', $userId)->first();
    }

    public function createForUser(string $userId)
    {
        return Wallet::create([
            'user_id' => $userId,
            'balance' => 0
        ]);
    }

    public function credit(
        string $userId,
        float $amount,
        string $type,
        ?string $reference = null
    ) {
        return DB::transaction(function () use ($userId, $amount, $type, $reference) {

            if ($reference && WalletTransaction::where('reference', $reference)->exists()) {
                return;
            }

            $wallet = Wallet::where('user_id', $userId)
                ->lockForUpdate()
                ->firstOrFail();

            $wallet->increment('balance', $amount);

            WalletTransaction::create([
                'user_id'   => $userId,
                'type'      => $type,
                'amount'    => $amount,
                'reference' => $reference
            ]);
        });
    }

    public function debit(
        string $userId,
        float $amount,
        string $type,
        ?string $reference = null
    ) {
        return DB::transaction(function () use ($userId, $amount, $type, $reference) {

            $wallet = Wallet::where('user_id', $userId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($wallet->balance < $amount) {
                throw new \RuntimeException('Solde insuffisant.');
            }

            $wallet->decrement('balance', $amount);

            WalletTransaction::create([
                'user_id'   => $userId,
                'type'      => $type,
                'amount'    => -$amount,  // montant négatif pour sortie
                'reference' => $reference
            ]);
        });
    }
}