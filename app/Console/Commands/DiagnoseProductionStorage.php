<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DiagnoseProductionStorage extends Command
{
    protected $signature = 'production:diagnose';
    protected $description = 'Diagnose storage issues in production';

    public function handle()
    {
        $this->info('=== PRODUCTION STORAGE DIAGNOSTIC ===');
        $this->newLine();

        // 1. Check APP_URL
        $this->info('1. APP_URL Configuration');
        $this->info('   Current APP_URL: ' . config('app.url'));
        $this->info('   Public disk URL: ' . config('filesystems.disks.public.url'));
        $this->newLine();

        // 2. Check storage symlink
        $this->info('2. Storage Symlink Check');
        $symlinkPath = public_path('storage');
        if (File::exists($symlinkPath)) {
            $this->info('   ✓ Symlink exists at: ' . $symlinkPath);
            if (File::isLink($symlinkPath)) {
                $target = readlink($symlinkPath);
                $this->info('   ✓ Symlink points to: ' . $target);
            } else {
                $this->warn('   ⚠ Path exists but is not a symlink (it\'s a directory)');
            }
        } else {
            $this->error('   ✗ Symlink does NOT exist at: ' . $symlinkPath);
            $this->warn('   Run: php artisan storage:link');
        }
        $this->newLine();

        // 3. Check storage directories
        $this->info('3. Storage Directories Check');
        $directories = [
            'storage/app/public',
            'storage/app/public/social-links',
            'storage/app/public/widgets',
            'storage/app/public/landing-pages',
            'storage/app/public/blog/media',
        ];

        foreach ($directories as $dir) {
            $fullPath = base_path($dir);
            if (File::exists($fullPath)) {
                $fileCount = count(File::files($fullPath));
                $this->info("   ✓ {$dir} exists ({$fileCount} files)");
            } else {
                $this->error("   ✗ {$dir} does NOT exist");
            }
        }
        $this->newLine();

        // 4. Check public disk files
        $this->info('4. Public Disk Files Check');
        $files = Storage::disk('public')->allFiles();
        $this->info('   Total files in public disk: ' . count($files));

        if (count($files) > 0) {
            $this->info('   Sample files:');
            $sample = array_slice($files, 0, 10);
            foreach ($sample as $file) {
                $url = config('filesystems.disks.public.url') . '/' . $file;
                $this->info("   - {$file}");
                $this->info("     URL: {$url}");
            }
        } else {
            $this->warn('   ⚠ No files found in public disk');
        }
        $this->newLine();

        // 5. Check file permissions
        $this->info('5. File Permissions Check');
        $publicPath = storage_path('app/public');
        if (File::exists($publicPath)) {
            $permissions = substr(sprintf('%o', fileperms($publicPath)), -4);
            $this->info("   storage/app/public permissions: {$permissions}");
            if ($permissions == '0755' || $permissions == '0777') {
                $this->info('   ✓ Permissions look correct');
            } else {
                $this->warn('   ⚠ Permissions might be too restrictive');
            }
        }
        $this->newLine();

        // 6. Test URL generation
        $this->info('6. URL Generation Test');
        $testPath = 'test.txt';
        $generatedUrl = config('filesystems.disks.public.url') . '/' . $testPath;
        $this->info("   Test URL for '{$testPath}': {$generatedUrl}");
        $this->newLine();

        // 7. Check if files are accessible via web
        $this->info('7. Web Accessibility Check');
        $this->warn('   Manual check needed: Open these URLs in browser:');
        $this->info('   - ' . config('app.url') . '/storage/social-links/facebook.gif');
        $this->info('   - ' . config('app.url') . '/storage/widgets/walinzi-sacco.png');
        $this->newLine();

        $this->info('=== DIAGNOSTIC COMPLETE ===');
    }
}
