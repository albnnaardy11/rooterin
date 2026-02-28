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
        Schema::create('seo_redirect_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('source_url')->index();
            $table->string('suggested_url');
            $table->decimal('confidence', 5, 2)->default(0);
            $table->text('reason')->nullable();
            $table->boolean('is_applied')->default(false);
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_redirect_suggestions');
    }
};
