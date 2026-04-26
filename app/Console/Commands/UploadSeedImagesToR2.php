<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UploadSeedImagesToR2 extends Command
{
    protected $signature = 'media:upload-seed-images {--force : Force upload without confirmation}';
    protected $description = 'Upload seed images from local storage to R2 for production';

    public function handle()
    {
        $disk = env('FILESYSTEM_DISK', 'r2_public');

        $this->info("=== UPLOADING SEED IMAGES TO {$disk} ===");
        $this->newLine();

        if (!$this->option('force') && !$this->confirm("This will upload seed images to '{$disk}'. Continue?")) {
            $this->warn('Upload cancelled.');
            return 1;
        }

        // Define seed image paths
        $seedImages = [
            // Social links
            'public/images/social-links/facebook.gif',
            'public/images/social-links/instagram.gif',
            'public/images/social-links/x.gif',
            'public/images/social-links/whatsapp.gif',
            'public/images/social-links/linkedin.gif',
            // Navigation logo
            'storage/app/public/socials/andabwa-logo.svg',
            // Widget images (if they exist)
            'storage/app/public/widget_images/andabwa-logo.svg',
            'storage/app/public/widget_images/walinzi-sacco.png',
            'storage/app/public/widget_images/eagle.png',
            'storage/app/public/widget_images/smile-logo.png',
        ];

        $uploadedCount = 0;
        $errorCount = 0;

        foreach ($seedImages as $localPath) {
            $fullPath = base_path($localPath);
            
            if (!File::exists($fullPath)) {
                $this->warn("File not found: {$localPath}");
                $errorCount++;
                continue;
            }

            try {
                $fileName = basename($localPath);
                $remotePath = 'seed-images/' . $fileName;
                
                Storage::disk($disk)->put($remotePath, File::get($fullPath));
                
                $this->info("✓ Uploaded: {$fileName}");
                $uploadedCount++;
            } catch (\Exception $e) {
                $this->error("✗ Error uploading {$localPath}: " . $e->getMessage());
                $errorCount++;
            }
        }

        $this->newLine();
        $this->info("=== UPLOAD COMPLETE ===");
        $this->info("Uploaded: {$uploadedCount}");
        $this->info("Errors: {$errorCount}");

        if ($uploadedCount > 0) {
            $this->newLine();
            $this->info('Now run the seeders to attach media:');
            $this->info('  php artisan db:seed --class=FooterSeeder');
            $this->info('  php artisan db:seed --class=NavigationLogoHeaderSeeder');
            $this->info('  php artisan db:seed --class=WidgetSeeder');
        }

        return 0;
    }
}
