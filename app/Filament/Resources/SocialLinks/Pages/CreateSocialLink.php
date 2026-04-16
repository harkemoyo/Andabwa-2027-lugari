<?php

namespace App\Filament\Resources\SocialLinks\Pages;

use App\Events\FooterUpdated;
use App\Filament\Resources\SocialLinks\SocialLinkResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSocialLink extends CreateRecord
{
    protected static string $resource = SocialLinkResource::class;
     protected function afterSave(): void
    {
        // Broadcast to all other connected clients via Reverb
        broadcast(new FooterUpdated())->toOthers();
    }
}
