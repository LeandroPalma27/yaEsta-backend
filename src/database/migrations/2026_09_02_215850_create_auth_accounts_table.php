<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auth_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('provider', 50);

            $table->string('provider_account_id')->nullable();

            $table->string('password_hash')->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'provider',
            ]);

            $table->unique([
                'provider',
                'provider_account_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_accounts');
    }
};
