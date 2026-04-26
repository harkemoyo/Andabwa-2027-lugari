<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Widget;
use App\Models\SocialLink;
use App\Models\NavigationLogoHeader;

class CheckMediaUrls extends Command
{
    protected $signature = 'media:check';
    protected $description = 'Check media URLs for widgets, social links, and navigation logos';

    public function handle()
    {
        $this->info('=== WIDGET MEDIA CHECK ===');
        $widgets = Widget::all();
        
        foreach ($widgets as $widget) {
            $this->info("Widget: {$widget->title}");
            $this->info("  Has Media: " . ($widget->hasMedia('widget_images') ? 'YES' : 'NO'));
            $this->info("  full_widget_image_path: {$widget->full_widget_image_path}");
            
            if ($widget->hasMedia('widget_images')) {
                $media = $widget->getFirstMedia('widget_images');
                $this->info("  Media URL: {$media->getUrl()}");
                $this->info("  Media Disk: {$media->disk}");
                $this->info("  Media Path: {$media->getPath()}");
            }
            $this->newLine();
        }

        $this->info('=== SOCIAL LINK MEDIA CHECK ===');
        $links = SocialLink::all();
        
        foreach ($links as $link) {
            $this->info("Social Link: {$link->platform_name}");
            $this->info("  Has Media: " . ($link->hasMedia('social_icons') ? 'YES' : 'NO'));
            $this->info("  full_image_path: {$link->full_image_path}");
            
            if ($link->hasMedia('social_icons')) {
                $media = $link->getFirstMedia('social_icons');
                $this->info("  Media URL: {$media->getUrl()}");
                $this->info("  Media Disk: {$media->disk}");
                $this->info("  Media Path: {$media->getPath()}");
            }
            $this->newLine();
        }

        $this->info('=== NAVIGATION LOGO MEDIA CHECK ===');
        $logos = NavigationLogoHeader::all();
        
        foreach ($logos as $logo) {
            $this->info("Navigation Logo ID: {$logo->id}");
            $this->info("  Has Media: " . ($logo->hasMedia('navigation_logos') ? 'YES' : 'NO'));
            $this->info("  full_logo_path: {$logo->full_logo_path}");
            
            if ($logo->hasMedia('navigation_logos')) {
                $media = $logo->getFirstMedia('navigation_logos');
                $this->info("  Media URL: {$media->getUrl()}");
                $this->info("  Media Disk: {$media->disk}");
                $this->info("  Media Path: {$media->getPath()}");
            }
            $this->newLine();
        }

        $this->info('=== STORAGE CONFIG ===');
        $this->info("FILESYSTEM_DISK: " . env('FILESYSTEM_DISK'));
        $this->info("Public Disk URL: " . config('filesystems.disks.public.url'));
    }
}
