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
        // Create the widget_impressions table if it doesn't exist
        // This migration was originally meant to change widget_id to string, but that breaks
        // the foreign key constraint since widgets.id is bigint. We'll keep it as bigint.
        if (!Schema::hasTable('widget_impressions')) {
            Schema::create('widget_impressions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('widget_id')->constrained('widgets')->onDelete('cascade');
                $table->string('session_id')->nullable();
                $table->string('ip')->nullable();
                $table->timestamp('viewed_at')->nullable();
                $table->index(['widget_id', 'session_id']);
            });
        }
        // If table exists, do nothing - keep widget_id as bigint to match widgets.id
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widget_impressions');
    }
};
