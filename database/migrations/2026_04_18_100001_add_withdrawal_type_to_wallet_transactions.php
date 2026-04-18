<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('REFERRAL_BONUS','LEVEL_BONUS','WITHDRAWAL') NOT NULL");
        }
        // SQLite stocke les enums comme varchar et n'impose pas de contrainte,
        // donc aucune modification structurelle n'est nécessaire.
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('REFERRAL_BONUS','LEVEL_BONUS') NOT NULL");
        }
    }
};
