<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama Kota: Jakarta Selatan, Bandung, dll
            $table->string('slug')->unique(); // jakarta-selatan
            $table->string('region')->nullable(); // Provinsi / Wilayah
            $table->text('description_prefix')->nullable(); // Custom content for this city
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_cities');
    }
};
