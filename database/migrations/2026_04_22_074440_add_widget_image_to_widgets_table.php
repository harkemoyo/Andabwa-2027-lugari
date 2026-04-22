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
        Schema::table('widgets', function (Blueprint $table) {
            if (!Schema::hasColumn('widgets', 'widget_image')) {
                $table->string('widget_image')->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('widgets', function (Blueprint $table) {
            if (Schema::hasColumn('widgets', 'widget_image')) {
                $table->dropColumn('widget_image');
            }
        });
    }
};
