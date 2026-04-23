<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CleanupProductionData;
use App\Console\Commands\VerifyStoragePaths;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register production cleanup command
Artisan::command('production:cleanup', function () {
    $this->call(CleanupProductionData::class);
})->purpose('Clean up production data - remove duplicates and orphaned records');

// Register storage verification command
Artisan::command('storage:verify', function () {
    $this->call(VerifyStoragePaths::class);
})->purpose('Verify all required storage files exist');

// Generate sitemap every day at midnight
Schedule::command('sitemap:generate')->daily();
