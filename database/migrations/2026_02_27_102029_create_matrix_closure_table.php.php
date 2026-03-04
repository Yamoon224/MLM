<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matrix_closure', function (Blueprint $table) {
            $table->integer('ancestor_id');
            $table->integer('descendant_id');
            $table->unsignedTinyInteger('depth');
            $table->primary(['ancestor_id', 'descendant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrix_closure');
    }
};
