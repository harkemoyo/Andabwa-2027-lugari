<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use Google\Client;
use Google\Service\SearchConsole;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the XML sitemap for SEO';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // 1. Add Static Pages
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create('/blog')->setPriority(0.8));

        // 2. Add Dynamic Blog Posts (Only Published)
        Post::where('is_published', true)->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create($post->getSitemapUrl())
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        });

        // 3. Save to public folder
        $sitemap->writeToFile(public_path('sitemap.xml'));

        // $this->info('Sitemap generated successfully!');


        $this->info('Sitemap generated. Notifying Google...');

        try {
            $client = new Client();
            $client->setAuthConfig(base_path(env('GOOGLE_SERVICE_ACCOUNT_JSON')));
            $client->addScope('https://www.googleapis.com/auth/webmasters');

            $searchConsole = new SearchConsole($client);
            $siteUrl = env('GOOGLE_SITE_URL');
            $sitemapUrl = $siteUrl . 'sitemap.xml';

            // Submit to Google
            $searchConsole->sitemaps->submit($siteUrl, $sitemapUrl);

            $this->info('Google notified successfully!');
        } catch (\Exception $e) {
            $this->error('Google notification failed: ' . $e->getMessage());
        }
    }
}
