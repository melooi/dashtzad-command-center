<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_qa_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('readiness_score')->default(0);
            $table->text('missing_items')->nullable();
            $table->timestamp('checked_at');
            $table->timestamps();

            $table->index(['product_id', 'checked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_qa_checks');
    }
};
