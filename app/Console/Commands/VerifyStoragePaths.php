<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class VerifyStoragePaths extends Command
{
    protected $signature = 'storage:verify';
    protected $description = 'Verify all required storage files exist';

    public function handle()
    {
        $this->info('=== VERIFYING STORAGE PATHS ===');
        $this->newLine();

        $requiredFiles = [
            'social-links/facebook.gif',
            'social-links/instagram.gif',
            'social-links/x.gif',
            'social-links/whatsapp.gif',
            'social-links/linkedin.gif',
            'widgets/easter.png',
            'widgets/smile-logo.png',
            'widgets/walinzi-sacco.png',
            'widgets/eagle.png',
            'widgets/andabwa-logo.svg',
            'landing-pages/hero/smile-logo.jpeg',
            'landing-pages/hero/walinzi.png',
        ];

        $missing = [];
        $existing = [];

        foreach ($requiredFiles as $file) {
            if (Storage::disk('public')->exists($file)) {
                $existing[] = $file;
                $this->info("✓ {$file}");
            } else {
                $missing[] = $file;
                $this->error("✗ {$file} - MISSING");
            }
        }

        $this->newLine();
        $this->info("Found: " . count($existing) . " files");
        $this->warn("Missing: " . count($missing) . " files");

        if (!empty($missing)) {
            $this->newLine();
            $this->warn('Missing files need to be uploaded to storage/app/public/');
            $this->newLine();
            $this->warn('To create missing directories:');
            foreach ($missing as $file) {
                $dir = dirname($file);
                $this->warn("  mkdir -p storage/app/public/{$dir}");
            }
        }

        $this->newLine();
        $this->info('Storage symlink check:');
        if (file_exists(public_path('storage'))) {
            $this->info('✓ public/storage symlink exists');
        } else {
            $this->error('✗ public/storage symlink MISSING - run: php artisan storage:link');
        }

        $this->newLine();
        $this->info('APP_URL check:');
        $this->info('Current APP_URL: ' . config('app.url'));
        $this->info('Public disk URL: ' . config('filesystems.disks.public.url'));

        return count($missing) === 0 ? Command::SUCCESS : Command::FAILURE;
    }
}
