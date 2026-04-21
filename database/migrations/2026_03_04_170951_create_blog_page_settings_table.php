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
        Schema::create('blog_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_subtitle')->default('Discover');
            $table->string('header_title')->default('Andabwa Lugari');
            $table->string('header_emoji')->default('✨ ⚡ 🚀');
            $table->string('search_title')->default('All Topics');
            $table->string('editorial_button_text')->default('Back to Editorial');
            $table->string('featured_insight_text')->default('Featured Insight');
            $table->string('share')->default('Share this piece');
            $table->string('view_all_button')->default('view all');
            $table->text('header_description')->nullable();
            $table->string('featured_title')->default('Featured Articles');
            $table->string('featured_description')->default('Highlighted  Projects.');
            $table->string('latest_title')->default('Latest Articles');
            $table->string('latest_description')->default('Discover the latest in  Projects.');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_page_settings');
    }
};
