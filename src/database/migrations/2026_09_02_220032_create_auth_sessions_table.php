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
        Schema::create('auth_sessions', function (Blueprint $table) {
            $table->id();

            $table->uuid('public_id')->unique()->after('id');

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('refresh_token_hash')->unique();

            $table->timestampTz('expires_at');
            $table->timestampTz('revoked_at')->nullable();

            $table->timestampTz('created_at')->useCurrent();

            $table->string('device_name')->nullable()->after('refresh_token_hash');
            $table->string('ip_address', 45)->nullable()->after('device_name');
            $table->text('user_agent')->nullable()->after('ip_address');

            $table->timestampTz('last_used_at')->nullable()->after('user_agent');

            $table->index(['user_id', 'revoked_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_sessions');
    }
};
