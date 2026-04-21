<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 
     */

    
    public function up(): void
    {
        Schema::table('blog_page_settings', function (Blueprint $table) {
             if (!Schema::hasColumn('sidebar_widgets', 'url')) {
                $table->string('view_all_button')->nullable()->after('show_category_filter');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_page_settings', function (Blueprint $table) {
            $table->dropColumn('view_all_button');
        });
    }
};
