<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class MatrixTestSeeder extends Seeder
{
    private int $maxChildren = 5;
    private int $maxLevel = 5;

    public function run(): void
    {
        $root = User::where('referral_code', 'ROOT123')->first();

        $this->generateChildren($root, 1);
    }

    private function generateChildren(User $parent, int $level): void
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

            $parent->increment('matrix_children_count');

            $this->generateChildren($child, $level + 1);
        }
    }
}