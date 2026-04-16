<?php

// database/seeders/FooterSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterInfo;
use App\Models\FooterCta;
use App\Models\SocialLink;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        FooterInfo::create([
            'company_name' => 'Andabwa MP 2027',
            'title' => 'imagess/andabwa-logo.svg',
            'description' => 'Let the people decide /n #Toa Jam in Lugari Constituency',
            'address' => 'Hurlingham, Nairobi, Kenya',
            'phone' => '+254 700000000',
            'email' => 'info@andabwa-foundation.com',
        ]);

        FooterCta::create([
            'title' => 'Stay Connected',
            'subtitle' => 'Join our newsletter to receive updates and promotions.',
            'button_text' => 'Subscribe Now',
            'button_link' => '#subscribe',
        ]);





        
        SocialLink::insert([
            [
                'platform_name' => 'Facebook',
                'url' => 'https://facebook.com',
                'image_path' => 'imagess/facebook.gif',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'platform_name' => 'Instagram',
                'url' => 'https://instagram.com',
                'image_path' => 'imagess/instagram.gif',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'platform_name' => 'X',
                'url' => 'https://x.com',
                'image_path' => 'imagess/x.gif',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'platform_name' => 'Whatsapp',
                'url' => 'https://whatsapp.com',
                'image_path' => 'imagess/whatsapp.gif',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'platform_name' => 'linkedin',
                'url' => 'https://linkedin.com',
                'image_path' => 'imagess/linkedin.gif',
                'is_active' => true,
                'order' => 5,
            ],


        ]);
    }
}
