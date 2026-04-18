<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_renewals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->decimal('amount', 12, 2);
            $table->string('payment_reference');
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_renewals');
    }
};
