<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_cities', function (Blueprint $table) {
            $table->text('lsi_keywords')->nullable(); // Semantic Keyword Cloud
        });
    }

    public function down(): void
    {
        Schema::table('seo_cities', function (Blueprint $table) {
            $table->dropColumn('lsi_keywords');
        });
    }
};
