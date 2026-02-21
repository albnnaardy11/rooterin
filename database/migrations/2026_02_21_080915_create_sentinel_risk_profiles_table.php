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
        Schema::create('sentinel_risk_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->integer('trust_score')->default(50);
            $table->integer('violation_count')->default(0);
            $table->decimal('is_bot_probability', 5, 4)->default(0.0000);
            $table->timestamp('last_seen_at')->nullable();
            $table->json('behavior_metadata')->nullable();
            $table->timestamps();
            
            // Indexing for high-performance cluster lookup
            $table->index('ip_address');
            $table->index('trust_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentinel_risk_profiles');
    }
};
