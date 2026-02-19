<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_redirects', function (Blueprint $create) {
            $create->id();
            $create->string('source_url')->unique();
            $create->string('destination_url');
            $create->integer('status_code')->default(301);
            $create->boolean('is_active')->default(true);
            $create->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_redirects');
    }
};
