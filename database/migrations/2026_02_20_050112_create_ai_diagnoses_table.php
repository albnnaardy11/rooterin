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
        Schema::create('ai_diagnoses', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->string('diagnose_id')->unique(); // #RT-YYYY-XXXX
            $table->string('result_label');
            $table->integer('confidence_score');
            $table->string('city_location')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('status', ['pending', 'contacted'])->default('pending');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_diagnoses');
    }
};
