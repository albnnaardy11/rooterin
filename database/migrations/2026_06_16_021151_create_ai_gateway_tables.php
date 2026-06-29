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
        Schema::create('ai_quotas', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name')->unique();
            $table->integer('daily_limit')->default(100);
            $table->integer('current_usage')->default(0);
            $table->date('last_reset_date');
            $table->string('assigned_model')->default('gemini'); // gemini or groq
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ai_logs', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name')->index();
            $table->string('model_used');
            $table->string('api_key_index')->nullable(); // which key was used
            $table->integer('latency_ms');
            $table->boolean('is_success');
            $table->string('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_logs');
        Schema::dropIfExists('ai_quotas');
    }
};
