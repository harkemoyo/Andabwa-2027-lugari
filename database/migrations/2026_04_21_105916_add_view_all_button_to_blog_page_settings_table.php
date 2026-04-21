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
        Schema::table('blog_page_settings', function (Blueprint $table) {
            $table->string('view_all_button')->default('view all')->after('share');
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
