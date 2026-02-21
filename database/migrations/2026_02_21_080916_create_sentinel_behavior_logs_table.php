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
        Schema::create('sentinel_behavior_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_profile_id')->constrained('sentinel_risk_profiles')->onDelete('cascade');
            $table->string('event_name');
            $table->integer('risk_delta');
            $table->json('context')->nullable();
            $table->timestamps();
            
            $table->index('risk_profile_id');
            $table->index('event_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentinel_behavior_logs');
    }
};
