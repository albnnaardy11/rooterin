<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->unique(); // Kata kunci yang akan di-auto link
            $table->string('target_url'); // Link tujuan (misal: halaman layanan)
            $table->integer('priority')->default(1); // Prioritas linking
            $table->integer('usage_count')->default(0); // Berapa kali link ini muncul
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_keywords');
    }
};
