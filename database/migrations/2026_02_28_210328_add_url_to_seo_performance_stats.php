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
        Schema::table('seo_performance_stats', function (Blueprint $table) {
            $table->string('url')->after('query')->index();
            $table->unique(['query', 'url', 'date']);
        });
    }

    public function down(): void
    {
        Schema::table('seo_performance_stats', function (Blueprint $table) {
            $table->dropUnique(['query', 'url', 'date']);
            $table->dropColumn('url');
        });
    }
};
