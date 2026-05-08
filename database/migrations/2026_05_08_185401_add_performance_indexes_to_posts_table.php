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
        Schema::table('posts', function (Blueprint $table) {
            // Add indexes for frequently queried columns
            $table->index('is_published');
            $table->index('is_featured');
            $table->index('category_id');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('slug');

            // Composite indexes for common query patterns
            $table->index(['is_published', 'created_at']);
            $table->index(['is_published', 'is_featured']);
            $table->index(['category_id', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['slug']);
            $table->dropIndex(['is_published', 'created_at']);
            $table->dropIndex(['is_published', 'is_featured']);
            $table->dropIndex(['category_id', 'is_published']);
        });
    }
};
