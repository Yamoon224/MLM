<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL ne supporte pas ALTER COLUMN pour les enums directement via Blueprint
        // On modifie via raw SQL
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('REFERRAL_BONUS','LEVEL_BONUS','WITHDRAWAL') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('REFERRAL_BONUS','LEVEL_BONUS') NOT NULL");
    }
};
