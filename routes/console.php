<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CleanupProductionData;
use App\Console\Commands\VerifyStoragePaths;
use App\Console\Commands\DiagnoseProductionStorage;
use App\Console\Commands\CheckMediaUrls;
use App\Console\Commands\MigrateMediaToR2;

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

// Register production diagnostic command
Artisan::command('production:diagnose', function () {
    $this->call(DiagnoseProductionStorage::class);
})->purpose('Diagnose storage issues in production');

// Register media URL check command
Artisan::command('media:check', function () {
    $this->call(CheckMediaUrls::class);
})->purpose('Check media URLs for widgets and social links');

// Register media migration command
Artisan::command('media:migrate-to-r2', function () {
    $this->call(MigrateMediaToR2::class);
})->purpose('Migrate all media from public disk to R2 disk for production');

// Generate sitemap every day at midnight
Schedule::command('sitemap:generate')->daily();
