<?php



namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Enums\MediaType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

// Increase memory limit for image processing
ini_set('memory_limit', '512M');

class PostSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Clear existing posts to avoid duplicates
            Post::query()->delete();

            $categories = Category::pluck('id');
            $tags = Tag::pluck('id');

            $this->command->info(sprintf('Found %d Categories and %d Tags.', $categories->count(), $tags->count()));

            if ($categories->isEmpty()) {
                $this->command->error('No categories found! Make sure CategorySeeder runs first.');
                return;
            }

            $resolvedPaths = $this->resolveMediaPaths();
            $existingImages = $this->getExistingImages($resolvedPaths);

            $this->logMediaAvailability($resolvedPaths, $existingImages);

            $projects = $this->getProjectsData();

            foreach ($projects as $index => $data) {
                $post = $this->createPostRecord($data, $index, $categories);
                $this->attachTags($post, $tags);
                $this->attachMediaToPost($post, $data, $index, $resolvedPaths, $existingImages);
            }

            $this->command->info(sprintf('Seeded %d posts successfully.', count($projects)));
        } catch (\Exception $e) {
            $this->command->error('Seeding failed: ' . $e->getMessage());
        }
    }

    /**
     * Resolves the physical paths for all media assets.
     */
    private function resolveMediaPaths(): array
    {
        $fileNames = [
            'scholorships.webp',
            'security.jpg',
            'www.ssvid.net--Andabwa-akanusha-kuwania-kiti-Cotu-Unknown-144p-h264-mp4.mp4',
            'andabwa-campaign-1.jpg',
            'andabwa-campaign-2.jpg',
            'andabwa-development.jpg',
            'andabwa-mp-campaign.png',
            'andabwa-speech.mp4',
        ];

        $baseDirs = [
            public_path('seed-images'),
            base_path('public/seed-images'),
            '/var/www/html/public/seed-images',
        ];

        $resolvedPaths = [];

        foreach ($fileNames as $fileName) {
            $foundPath = '';
            foreach ($baseDirs as $dir) {
                $path = rtrim($dir, '/') . '/' . $fileName;
                if (File::exists($path)) {
                    $foundPath = $path;
                    break;
                }
            }
            // Fallback to the first possible path if it doesn't exist
            $resolvedPaths[$fileName] = $foundPath !== '' ? $foundPath : $baseDirs[0] . '/' . $fileName;
        }

        return $resolvedPaths;
    }

    /**
     * Filters available paths down to only the images that actually exist on disk.
     */
    private function getExistingImages(array $paths): array
    {
        $imageKeys = [
            'scholorships.webp',
            'security.jpg',
            'andabwa-campaign-1.jpg',
            'andabwa-campaign-2.jpg',
            'andabwa-development.jpg',
            'andabwa-mp-campaign.png',
        ];

        $available = array_map(fn($key) => $paths[$key], $imageKeys);

        return array_values(array_filter($available, fn($path) => File::exists($path)));
    }

    /**
     * Logs the availability of files to the console.
     */
    private function logMediaAvailability(array $paths, array $existingImages): void
    {
        $hasAnyImages = count($existingImages) > 0;
        $hasAnyVideos = File::exists($paths['www.ssvid.net--Andabwa-akanusha-kuwania-kiti-Cotu-Unknown-144p-h264-mp4.mp4'])
            || File::exists($paths['andabwa-speech.mp4']);

        if (!$hasAnyImages && !$hasAnyVideos) {
            $this->command->error('No seed images or videos found! Media seeding will be skipped.');
        }

        foreach ($paths as $fileName => $path) {
            $status = File::exists($path) ? 'YES' : 'NO';
            $this->command->info("Media check -> {$fileName} Exists: {$status} | Path: {$path}");
        }
    }



    /**
     * Corrected method with fixed syntax and logic
     */

    private function createPostRecord(array $data, int $index, $categories): Post
    {
        $linkData = null;

        // Handle Youtube Previews
        if ($data['media_type'] === MediaType::Youtube && !empty($data['external_url'])) {
            $linkData = [
                'title'       => 'Video: ' . $data['title'],
                'image'       => "https://img.youtube.com/vi/" . $this->extractYoutubeId($data['external_url']) . "/hqdefault.jpg",
                'description' => 'Automatically fetched during seeding.',
                'type'        => 'video'
            ];
        }
        // Handle Local Video Previews (like your andabwa-speech.mp4)
        elseif ($data['media_type'] === MediaType::Youtube && !empty($data['external_url'])) {
            $linkData = [
                'title'       => $data['title'],
                'image'       => null, // Local videos usually don't have auto-generated thumbnails
                'description' => 'Local video file.',
                'type'        => 'video'
            ];
        }

        return Post::create([
            'title'             => $data['title'],
            'content'           => $data['content'],
            // FIX: Removed ->id because $categories->random() is already an integer
            'category_id'       => $categories->isNotEmpty() ? $categories->random() : null,
            'is_published'      => true,
            'is_featured'       => $index < 8,
            'media_type'        => $data['media_type'],
            'meta_title'        => $data['meta_title'],
            'meta_description'  => $data['meta_description'],
            'external_url'      => $data['external_url'],
            'link_preview_data' => $linkData,
        ]);
    }
    
    private function attachTags(Post $post, Collection $tags): void
    {
        if ($tags->isNotEmpty()) {
            $post->tags()->sync($tags->random(min(2, $tags->count()))->toArray());
        }
    }

    /**
     * Routes the media attachment logic based on the media type.
     */
    private function attachMediaToPost(Post $post, array $data, int $index, array $resolvedPaths, array $existingImages): void
    {
        if ($post->getMedia('featured')->isNotEmpty()) {
            return;
        }

        if ($data['media_type'] === MediaType::Image) {
            $this->handleImageMedia($post, $data, $index, $resolvedPaths, $existingImages);
        } elseif ($data['media_type'] === MediaType::LocalVideo) {
            $this->handleVideoMedia($post, $data, $resolvedPaths);
        }
    }

    /**
     * Handles attaching Image media specifically.
     */
    private function handleImageMedia(Post $post, array $data, int $index, array $paths, array $existingImages): void
    {
        if (empty($existingImages)) {
            $this->command->error('No existing images found for media attachment, creating placeholder');
            $this->createPlaceholderMedia($post, 'image');
            return;
        }

        // Deterministic assignment
        $imageKey = crc32($data['title'] . $index) % count($existingImages);
        $imagePath = $existingImages[$imageKey];

        // Specific Overrides
        if (str_contains($data['title'], 'Scholarships')) {
            $imagePath = $paths['scholorships.webp'];
        } elseif (str_contains($data['title'], 'Peace and Security')) {
            $imagePath = $paths['security.jpg'];
        } elseif (str_contains($data['title'], 'Development Projects Launch')) {
            $imagePath = $paths['andabwa-development.jpg'];
        } elseif (str_contains($data['title'], 'MP 2027 Campaign')) {
            $imagePath = $paths['andabwa-mp-campaign.png'];
        }

        if (File::exists($imagePath)) {
            $this->command->info('Adding media from: ' . basename($imagePath) . ' to: ' . $data['title']);
            $post->addMedia($imagePath)
                ->preservingOriginal()
                ->toMediaCollection('featured', 'public');
        } else {
            $this->command->error('Image file not found: ' . $imagePath);
        }
    }

    /**
     * Handles attaching Video media specifically.
     */
    private function handleVideoMedia(Post $post, array $data, array $paths): void
    {
        if (str_contains($data['title'], 'Documentary')) {
            $videoPath = $paths['www.ssvid.net--Andabwa-akanusha-kuwania-kiti-Cotu-Unknown-144p-h264-mp4.mp4'];
        } elseif (str_contains($data['title'], 'Campaign Vision')) {
            $videoPath = $paths['andabwa-speech.mp4'];
        } else {
            $videoPath = $paths['www.ssvid.net--Andabwa-akanusha-kuwania-kiti-Cotu-Unknown-144p-h264-mp4.mp4'];
        }

        if (File::exists($videoPath)) {
            $this->command->info('Adding video from: ' . basename($videoPath));
            try {
                $post->addMedia($videoPath)
                    ->preservingOriginal()
                    ->toMediaCollection('featured', env('FILESYSTEM_DISK', 'public'));
            } catch (\Exception $e) {
                if (str_contains(strtolower($e->getMessage()), 'ffprobe') || str_contains(strtolower($e->getMessage()), 'ffmpeg')) {
                    $this->command->warn('FFmpeg/FFProbe not installed. Skipping video thumbnail generation.');

                    $post->addMedia($videoPath)
                        ->preservingOriginal()
                        ->toMediaCollection('featured', env('FILESYSTEM_DISK', 'public'));
                } else {
                    throw $e;
                }
            }
        } else {
            $this->command->error('Video file not found: ' . $videoPath . ', creating placeholder');
            $this->createPlaceholderMedia($post, 'video');
        }
    }

    /**
     * Creates placeholder media when seed images are missing.
     */
    private function createPlaceholderMedia(Post $post, string $mediaType): void
    {
        $placeholderPath = storage_path('app/public/placeholder-' . $mediaType . '.txt');
        $content = "Placeholder for {$mediaType} - Post: {$post->title}";

        file_put_contents($placeholderPath, $content);

        $post->addMedia($placeholderPath)
            ->preservingOriginal()
            ->toMediaCollection('featured', 'public');

        $this->command->info('Created placeholder media for: ' . $post->title);
    }






    /**
     * Returns the array of project data to seed.
     */
    private function getProjectsData(): array
    {
        return [
            [
                'title' => 'Empowering Lugari Youth through Scholarships',
                'media_type' => MediaType::Image,
                'content' => 'Dr. Andabwa OGW scholarship launch for bright needy students.',
                'meta_title' => 'Lugari Youth Scholarships | Dr. Andabwa OGW',
                'meta_description' => 'Education support for needy students in Lugari.',
                'external_url' => null,
            ],
            [
                'title' => 'Documentary: I cant Unsit Atwoli',
                'media_type' => MediaType::LocalVideo,
                'content' => 'Watch the full video of the groundbreaking ceremony.',
                'meta_title' => 'Walinzi Sacco Groundbreaking Video',
                'meta_description' => 'Video highlights of the housing project launch.',
                'external_url' => null,
            ],
            [
                'title' => 'KNPSWU National Security Reforms Update',
                'media_type' => MediaType::Youtube,
                'content' => 'Latest updates on national security reforms.',
                'meta_title' => 'Security Reforms | KNPSWU Update',
                'meta_description' => 'National security and union updates.',
                'external_url' => 'https://youtube.com/watch?v=jNQXAC9IVRw',
            ],
            [
                'title' => 'Featured Article: The Future of Lugari Saccos',
                'media_type' => MediaType::Article,
                'content' => 'Read this in-depth analysis on the Daily Nation website about the economic impact of Lugari Saccos.',
                'meta_title' => 'Lugari Sacco Economic Impact Article',
                'meta_description' => 'Analysis of how Walinzi Sacco is changing lives in Lugari constituency.',
                'external_url' => 'https://nation.africa/kenya/business/saccos-lugari',
            ],
            [
                'title' => 'Peace and Security Forums in Kakamega',
                'media_type' => MediaType::Image,
                'content' => 'Community-led peace forums strengthen local security ties.',
                'meta_title' => 'Kakamega Peace Forums | Dr. Andabwa OGW',
                'meta_description' => 'Dr. Andabwa leads security forums in Kakamega.',
                'external_url' => null,
            ],
            [
                'title' => 'Walinzi Sacco: Member Registration Guide',
                'media_type' => MediaType::Youtube,
                'content' => 'Tutorial video for new Sacco members.',
                'meta_title' => 'Walinzi Sacco Registration Tutorial',
                'meta_description' => 'Step-by-step guide for Sacco membership.',
                'external_url' => 'https://youtube.com/watch?v=9bZkp7q19f0',
            ],
            [
                'title' => 'Disability is Not Inability',
                'media_type' => MediaType::Article,
                'content' => 'Key campaign message and web story for Dr. Isaac GM Andabwa focused on inclusion and ability in Lugari.',
                'meta_title' => 'Disability is Not Inability | Dr. Isaac GM Andabwa',
                'meta_description' => 'Campaign story focused on inclusion and ability in Lugari.',
                'external_url' => 'https://www.vipasho.co.ke/2026/02/disability-is-not-inability-dr-isaac-gm.html',
            ],
            [
                'title' => 'Technology Skills Training Center',
                'media_type' => MediaType::Article,
                'content' => 'Establishment of technology training center to equip Lugari residents with digital skills for the modern economy and job market.',
                'meta_title' => 'Technology Training | Digital Skills Lugari',
                'meta_description' => 'Digital skills training for modern jobs and opportunities.',
                'external_url' => 'https://www.techweez.com/2023/11/digital-skills-training-kenya-youth-employment',
            ],
            [
                'title' => 'Women Empowerment Initiative Launch',
                'media_type' => MediaType::Article,
                'content' => 'Launch of comprehensive women empowerment program focusing on entrepreneurship and leadership development in Lugari.',
                'meta_title' => 'Women Empowerment | Lugari 2027',
                'meta_description' => 'Economic empowerment and leadership training for women.',
                'external_url' => 'https://www.citizen.digital/news/women-empowerment-key-to-economic-development-352866',
            ],
            [
                'title' => 'Road Infrastructure Development Update',
                'media_type' => MediaType::Youtube,
                'content' => 'Latest updates on road construction projects across Lugari constituency. Improved connectivity for rural areas.',
                'meta_title' => 'Lugari Road Development Update',
                'meta_description' => 'Infrastructure improvements for better connectivity.',
                'external_url' => 'https://youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'title' => 'Agricultural Modernization Program',
                'media_type' => MediaType::Youtube,
                'content' => 'Introduction of modern farming techniques and equipment to boost agricultural productivity in Lugari.',
                'meta_title' => 'Agricultural Modernization | Lugari Farmers',
                'meta_description' => 'Modern farming solutions for increased productivity.',
                'external_url' => 'https://youtube.com/watch?v=3JZ_D3ELwOQ',
            ],
            [
                'title' => 'Market Infrastructure Modernization',
                'media_type' => MediaType::Article,
                'content' => 'Modernization of local markets to improve trading conditions and economic opportunities for Lugari traders and farmers.',
                'meta_title' => 'Market Modernization | Lugari Economy',
                'meta_description' => 'Better markets for economic growth in Lugari.',
                'external_url' => 'https://www.businessdailyafrica.com/markets/markets-modernisation-boosts-trade-3678946',
            ],
            [
                'title' => 'Andabwa Campaign Rally in Lugari Town',
                'media_type' => MediaType::Image,
                'content' => 'Massive turnout at Dr. Andabwa\'s campaign rally in Lugari Town center. Thousands of supporters came to show their support for the 2027 MP candidacy.',
                'meta_title' => 'Lugari Campaign Rally Success | Dr. Andabwa 2027',
                'meta_description' => 'Historic campaign rally with overwhelming community support.',
                'external_url' => null,
            ],
            [
                'title' => 'Development Projects Launch Ceremony',
                'media_type' => MediaType::Image,
                'content' => 'Dr. Andabwa launches multiple development projects across Lugari constituency, including water systems, road improvements, and health center upgrades.',
                'meta_title' => 'Lugari Development Projects Launch',
                'meta_description' => 'Comprehensive development initiatives for Lugari constituency.',
                'external_url' => null,
            ],
            [
                'title' => 'Dr. Andabwa MP 2027 Campaign Vision',
                'media_type' => MediaType::LocalVideo,
                'content' => 'Watch Dr. Andabwa deliver his powerful vision for Lugari constituency in 2027. Comprehensive development plans and community empowerment strategies.',
                'meta_title' => 'Andabwa 2027 Campaign Vision Speech',
                'meta_description' => 'Complete vision for Lugari\'s future development and prosperity.',
                'external_url' => null,
            ],
            [
                'title' => 'Community Development Forum Highlights',
                'media_type' => MediaType::Image,
                'content' => 'Key highlights from the community development forum where residents discussed priority projects and development needs with Dr. Andabwa.',
                'meta_title' => 'Community Development Forum | Lugari 2027',
                'meta_description' => 'Resident-led development planning and priority setting.',
                'external_url' => null,
            ],
            [
                'title' => 'Healthcare Initiative for Lugari Residents',
                'media_type' => MediaType::Image,
                'content' => 'Dr. Andabwa announces comprehensive healthcare program for Lugari residents, including mobile clinics and health insurance support.',
                'meta_title' => 'Lugari Healthcare Initiative | Dr. Andabwa',
                'meta_description' => 'Affordable healthcare access for all Lugari residents.',
                'external_url' => null,
            ],
            [
                'title' => 'Water Supply Project Commissioning',
                'media_type' => MediaType::Image,
                'content' => 'Commissioning of new water supply projects to ensure clean water access for all Lugari residents.',
                'meta_title' => 'Clean Water Project | Lugari Development',
                'meta_description' => 'Access to clean water for every household in Lugari.',
                'external_url' => null,
            ],
            [
                'title' => 'Education Infrastructure Improvements',
                'media_type' => MediaType::Image,
                'content' => 'Renovation and construction of new classrooms and educational facilities across Lugari constituency.',
                'meta_title' => 'Education Development | Lugari Schools',
                'meta_description' => 'Better learning environments for Lugari students.',
                'external_url' => null,
            ],
            [
                'title' => 'Digital Connectivity Expansion',
                'media_type' => MediaType::Image,
                'content' => 'Expansion of internet connectivity and digital infrastructure to bridge the digital divide in Lugari.',
                'meta_title' => 'Digital Lugari | Internet Connectivity',
                'meta_description' => 'Bridging the digital divide for Lugari residents.',
                'external_url' => null,
            ],
            [
                'title' => 'Sports and Recreation Facilities Development',
                'media_type' => MediaType::Image,
                'content' => 'Development of modern sports facilities and recreation centers for youth engagement and community wellness.',
                'meta_title' => 'Sports Development | Lugari Recreation',
                'meta_description' => 'Modern sports facilities for youth development.',
                'external_url' => null,
            ],
            [
                'title' => 'Security Equipment for Local Police',
                'media_type' => MediaType::Image,
                'content' => 'Provision of modern security equipment and vehicles to enhance security operations in Lugari.',
                'meta_title' => 'Security Enhancement | Lugari Police',
                'meta_description' => 'Better security equipment for community safety.',
                'external_url' => null,
            ],
            [
                'title' => 'Renewable Energy Projects Initiative',
                'media_type' => MediaType::Youtube,
                'content' => 'Launch of renewable energy projects including solar power installations for public facilities.',
                'meta_title' => 'Renewable Energy | Green Lugari',
                'meta_description' => 'Sustainable energy solutions for Lugari.',
                'external_url' => 'https://youtube.com/watch?v=jNQXAC9IVRw',
            ],
            [
                'title' => 'Senior Citizens Support Program',
                'media_type' => MediaType::Image,
                'content' => 'Comprehensive support program for senior citizens including healthcare, social services, and community engagement.',
                'meta_title' => 'Elderly Care | Senior Citizens Support',
                'meta_description' => 'Support and care for Lugari senior citizens.',
                'external_url' => null,
            ],
            [
                'title' => 'Tourism Development Initiative',
                'media_type' => MediaType::Image,
                'content' => 'Development of tourism potential in Lugari including cultural sites and natural attractions for economic growth.',
                'meta_title' => 'Tourism Development | Lugari Tourism',
                'meta_description' => 'Unlocking Lugari\'s tourism potential.',
                'external_url' => null,
            ],
            [
                'title' => 'Microfinance Support for Small Businesses',
                'media_type' => MediaType::Youtube,
                'content' => 'Microfinance program to support small and medium enterprises in Lugari with affordable financing.',
                'meta_title' => 'Microfinance Support | Lugari Businesses',
                'meta_description' => 'Financial support for local entrepreneurs.',
                'external_url' => 'https://youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'title' => 'Housing Development Project',
                'media_type' => MediaType::Image,
                'content' => 'Affordable housing development project to provide decent housing for low-income families in Lugari.',
                'meta_title' => 'Housing Development | Affordable Homes Lugari',
                'meta_description' => 'Decent housing for all Lugari residents.',
                'external_url' => null,
            ],
            [
                'title' => 'Environmental Conservation Campaign',
                'media_type' => MediaType::Youtube,
                'content' => 'Environmental conservation and tree planting campaign to promote sustainable development in Lugari.',
                'meta_title' => 'Green Lugari | Environmental Conservation',
                'meta_description' => 'Sustainable development for future generations.',
                'external_url' => 'https://youtube.com/watch?v=9bZkp7q19f0',
            ],
            [
                'title' => 'Youth Employment and Skills Training Program',
                'media_type' => MediaType::Article,
                'content' => 'Comprehensive youth empowerment program focusing on skills training and job creation in Lugari constituency.',
                'meta_title' => 'Youth Employment Program | Lugari 2027',
                'meta_description' => 'Skills training and job opportunities for Lugari youth.',
                'external_url' => 'https://www.standardmedia.co.ke/kenya/news/article/1500446407/youth-employment-programme-creates-10000-jobs',
            ],
        ];
    }






    /**
     * Add this helper method to resolve the "Unknown method" error
     */
    private function extractYoutubeId(string $url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return 'default'; // Fallback ID if regex fails
    }
}
