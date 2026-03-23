<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('cascade');
                
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content')->nullable();

            // Media & SEO
            $table->string('media_type')->default('article');
            $table->string('meta_title', 100)->nullable(); // Increased for safety
            $table->string('meta_description', 255)->nullable(); // Standard SEO length

            // System Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);

            // External / Metadata
            $table->text('external_url')->nullable();
            $table->json('link_preview_data')->nullable();
            $table->timestamps();

            // Composite Index for high-speed feed loading
            $table->index(['is_published', 'is_featured', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

