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
        Schema::create('seo_404_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->integer('hits')->default(1);
            $table->timestamp('last_hit')->useCurrent();
            $table->boolean('is_redirected')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_404_logs');
    }
};
