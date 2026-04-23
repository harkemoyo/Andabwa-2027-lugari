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
        Schema::create('widget_impressions', function (Blueprint $table) {
            $table->id();
            $table->string('widget_id')->index(); // Slug or ID of the widget
            $table->string('session_id')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->timestamp('viewed_at')->useCurrent();

            // Prevent duplicate spam from the same session/IP on the same widget
            // Note: Use this carefully depending on your "Unique" definition
            $table->unique(['widget_id', 'session_id', 'ip'], 'unique_impression_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widget_impressions');
    }
};
