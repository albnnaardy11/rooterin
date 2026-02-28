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
        Schema::table('seo_redirects', function (Blueprint $table) {
            $table->integer('hits')->default(0)->after('is_active');
            $table->timestamp('last_hit_at')->nullable()->after('hits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_redirects', function (Blueprint $table) {
            //
        });
    }
};
