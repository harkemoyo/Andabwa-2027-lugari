<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('string_on_impressions', function (Blueprint $table) {
            // For PostgreSQL, you sometimes need to explicitly cast the type when changing from BigInt to String
            DB::statement('ALTER TABLE widget_impressions ALTER COLUMN widget_id TYPE VARCHAR(255) USING widget_id::VARCHAR');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('string_on_impressions', function (Blueprint $table) {
            // Revert back to BigInt if needed (will fail if strings like 'hero_banner' exist, but good practice)
            DB::statement('ALTER TABLE widget_impressions ALTER COLUMN widget_id TYPE BIGINT USING widget_id::BIGINT');
        });
    }
};
