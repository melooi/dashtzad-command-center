<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panel_users', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 15)->unique();
            $table->string('name')->nullable();
            $table->string('telegram_id', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->text('access_reason')->nullable();
            $table->string('referrer')->nullable();
            $table->string('role', 50)->default('viewer');
            $table->string('status', 30)->default('pending_profile');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panel_users');
    }
};
