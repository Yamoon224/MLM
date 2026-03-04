<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class FullMatrixSeeder extends Seeder
{
    private int $maxChildren = 5;
    private int $maxLevel = 5;

    public function run(): void
    {
        DB::transaction(function () {

            // 1️⃣ Création root admin
            $root = User::create([
                'full_name' => 'Root Admin',
                'email' => 'admin@test.com',
                'phone' => '0100000000',
                'password' => Hash::make('password'),
                'referral_code' => 'ROOT123',
                'sponsor_id' => null,
                'matrix_parent_id' => null,
                'matrix_level' => 0,
                'matrix_children_count' => 0
            ]);

            Wallet::create([
                'user_id' => $root->id,
                'balance' => 0
            ]);

            // 2️⃣ Génération matricielle complète
            $this->generateChildren($root, 1);

            // 3️⃣ Bonus de parrainage et niveaux
            $this->simulateBonuses();
        });
    }

    private function generateChildren(User $parent, int $level)
    {
        if ($level > $this->maxLevel) {
            return;
        }

        for ($i = 1; $i <= $this->maxChildren; $i++) {

            $child = User::create([
                'full_name' => "User L{$level}-{$i}-{$parent->id}",
                'email' => Str::uuid() . '@test.com',
                'phone' => '07' . rand(10000000, 99999999),
                'password' => Hash::make('password'),
                'referral_code' => strtoupper(Str::random(8)),
                'sponsor_id' => $parent->id,
                'matrix_parent_id' => $parent->id,
                'matrix_level' => $level,
                'matrix_children_count' => 0
            ]);

            Wallet::create([
                'user_id' => $child->id,
                'balance' => 0
            ]);

            // Incrément children count
            $parent->increment('matrix_children_count');

            // Insérer dans closure table
            $this->insertClosure($parent, $child);

            // Générer récursivement le niveau suivant
            $this->generateChildren($child, $level + 1);
        }
    }

    private function insertClosure(User $parent, User $child)
    {
        // Parent direct
        DB::table('matrix_closure')->insert([
            'ancestor_id' => $parent->id,
            'descendant_id' => $child->id,
            'depth' => 1
        ]);

        // Tous les ancêtres du parent
        $ancestors = DB::table('matrix_closure')
            ->where('descendant_id', $parent->id)
            ->get();

        foreach ($ancestors as $ancestor) {
            DB::table('matrix_closure')->insert([
                'ancestor_id' => $ancestor->ancestor_id,
                'descendant_id' => $child->id,
                'depth' => $ancestor->depth + 1
            ]);
        }
    }

    private function simulateBonuses()
    {
        $users = User::all();

        foreach ($users as $user) {
            // 1️⃣ Bonus de parrainage pour le sponsor direct
            if ($user->sponsor_id) {
                WalletTransaction::create([
                    'user_id' => $user->sponsor_id,
                    'type' => 'REFERRAL_BONUS',
                    'amount' => 100, // montant du bonus
                    'reference' => 'REF_' . $user->id
                ]);

                // crédit wallet
                Wallet::where('user_id', $user->sponsor_id)->increment('balance', 100);
            }

            // 2️⃣ Bonus de niveau pour tous les ancêtres
            $ancestors = DB::table('matrix_closure')
                ->where('descendant_id', $user->id)
                ->get();

            foreach ($ancestors as $ancestor) {
                // bonus par niveau si le nombre d’enfants direct au niveau correspondant est complet
                $level = $ancestor->depth;

                if ($level > $this->maxLevel) continue;

                $expected = pow($this->maxChildren, $level);
                $count = DB::table('matrix_closure')
                    ->where('ancestor_id', $ancestor->ancestor_id)
                    ->where('depth', $level)
                    ->count();

                if ($count == $expected) {
                    $wallet = Wallet::where('user_id', $ancestor->ancestor_id)->first();
                    // vérifier qu’on a pas déjà crédité ce niveau
                    $exists = WalletTransaction::where('user_id', $ancestor->ancestor_id)
                        ->where('type', 'LEVEL_BONUS')
                        ->where('reference', 'LEVEL_' . $level . '_' . $ancestor->ancestor_id)
                        ->exists();

                    if (!$exists) {
                        WalletTransaction::create([
                            'user_id' => $ancestor->ancestor_id,
                            'type' => 'LEVEL_BONUS',
                            'amount' => 50 * $level, // montant scalable par niveau
                            'reference' => 'LEVEL_' . $level . '_' . $ancestor->ancestor_id
                        ]);

                        $wallet->increment('balance', 50 * $level);
                    }
                }
            }
        }
    }
}