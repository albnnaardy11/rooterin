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
            $table->text('recommended_tools')->nullable()->after('analysis_version');
        });
    }

    public function down(): void
    {
        Schema::table('ai_diagnoses', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn('recommended_tools');
        });
    }
};
