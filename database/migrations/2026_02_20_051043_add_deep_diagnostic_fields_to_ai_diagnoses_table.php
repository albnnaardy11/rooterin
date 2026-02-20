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
        Schema::table('ai_diagnoses', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->string('audio_label')->nullable()->after('result_label');
            $table->integer('audio_confidence')->nullable()->after('audio_label');
            $table->json('survey_data')->nullable()->after('audio_confidence');
            $table->string('final_deep_score')->nullable()->after('survey_data'); // A-E Ranking
            $table->string('analysis_version')->default('2.0-Deep')->after('final_deep_score');
        });
    }

    public function down(): void
    {
        Schema::table('ai_diagnoses', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn(['audio_label', 'audio_confidence', 'survey_data', 'final_deep_score', 'analysis_version']);
        });
    }
};
