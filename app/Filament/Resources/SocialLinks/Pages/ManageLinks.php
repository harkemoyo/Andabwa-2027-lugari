<?php

namespace App\Filament\Resources\SocialLinks\Pages;

use App\Events\FooterUpdated;
use App\Filament\Resources\SocialLinks\SocialLinkResource;

use Filament\Resources\Pages\ManageRecords;

class ManageLinks extends ManageRecords
{
    protected static string $resource = SocialLinkResource::class;

     protected function afterSave(): void
    {
        // Broadcast to all other connected clients via Reverb
        broadcast(new FooterUpdated())->toOthers();
    }
}
