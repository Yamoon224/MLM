<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0
            ]);
        });
    }
}