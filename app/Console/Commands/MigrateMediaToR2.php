<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class MigrateMediaToR2 extends Command
{
    protected $signature = 'media:migrate-to-r2 {--force : Force migration without confirmation}';
    protected $description = 'Migrate all media from public disk to R2 disk for production';

    public function handle()
    {
        $fromDisk = 'public';
        $toDisk = env('FILESYSTEM_DISK', 'r2_public');

        $this->info("=== MEDIA MIGRATION: {$fromDisk} → {$toDisk} ===");
        $this->newLine();

        if (!$this->option('force') && !$this->confirm("This will migrate all media from '{$fromDisk}' to '{$toDisk}'. Continue?")) {
            $this->warn('Migration cancelled.');
            return 1;
        }

        $mediaItems = Media::where('disk', $fromDisk)->get();
        
        // Ensure we're working with model instances
        $mediaItems = $mediaItems->map(function ($item) {
            return Media::find($item->id);
        })->filter();
        $total = $mediaItems->count();

        if ($total === 0) {
            $this->info('No media items found on public disk.');
            return 0;
        }

        $this->info("Found {$total} media items to migrate.");
        $this->newLine();

        $progressBar = $this->output->createProgressBar($total);
        $progressBar->start();

        $successCount = 0;
        $errorCount = 0;

        foreach ($mediaItems as $media) {
            try {
                // Check if file exists on source disk
                if (!Storage::disk($fromDisk)->exists($media->id . '/' . $media->file_name)) {
                    $this->newLine();
                    $this->warn("File not found: {$media->id}/{$media->file_name}");
                    $errorCount++;
                    $progressBar->advance();
                    continue;
                }

                // Read file from source disk
                $fileContent = Storage::disk($fromDisk)->get($media->id . '/' . $media->file_name);

                // Write file to destination disk
                Storage::disk($toDisk)->put($media->id . '/' . $media->file_name, $fileContent);

                // Also migrate conversions if they exist
                $conversions = $media->conversions ?? [];
                foreach ($conversions as $conversion) {
                    $conversionPath = $media->id . '/conversions/' . $conversion->name . '-' . $media->file_name;
                    if (Storage::disk($fromDisk)->exists($conversionPath)) {
                        $conversionContent = Storage::disk($fromDisk)->get($conversionPath);
                        Storage::disk($toDisk)->put($conversionPath, $conversionContent);
                    }
                }

                // Update media record disk
                $media->disk = $toDisk;
                $media->save();

                $successCount++;
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Error migrating media ID {$media->id}: " . $e->getMessage());
                $errorCount++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->newLine();

        $this->info("=== MIGRATION COMPLETE ===");
        $this->info("Success: {$successCount}");
        $this->info("Errors: {$errorCount}");
        $this->info("Total: {$total}");

        if ($errorCount > 0) {
            $this->warn('Some media items failed to migrate. Check the errors above.');
            return 1;
        }

        $this->info('All media successfully migrated to ' . $toDisk);
        return 0;
    }
}
