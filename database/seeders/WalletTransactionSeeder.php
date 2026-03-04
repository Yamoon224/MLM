<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Repositories\Contracts\WalletRepositoryInterface;

class WalletTransactionSeeder extends Seeder
{
    public function run(WalletRepositoryInterface $wallets)
    {
        // Bonus de parrainage : 100 par filleul direct
        User::whereNotNull('sponsor_id')->get()->each(function ($user) use ($wallets) {

            $wallets->credit(
                $user->sponsor_id,
                100, // montant du bonus
                'REFERRAL_BONUS',
                'REF_' . $user->id
            );
        });

        // Bonus de niveau : 50 par niveau rempli
        User::where('matrix_level', 0)->get()->each(function ($user) use ($wallets) {
            $descendants = $user->descendants()->get(); // via relation closure
            $expected = pow(5, 1); // niveau 1 pour test
            if ($descendants->count() >= $expected) {
                $wallets->credit(
                    $user->id,
                    50,
                    'LEVEL_BONUS',
                    'LEVEL_1_' . $user->id
                );
            }
        });
    }
}