<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('localized_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_city_id')->nullable()->constrained('seo_cities')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('location_suburb')->nullable(); // Misal: Menteng, Rungkut
            $table->integer('rating')->default(5);
            $table->text('review_text');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('localized_reviews');
    }
};
