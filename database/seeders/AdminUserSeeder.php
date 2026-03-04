<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
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
    }
}