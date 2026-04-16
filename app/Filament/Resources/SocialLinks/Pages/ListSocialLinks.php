<?php

namespace App\Filament\Resources\SocialLinks\Pages;

use App\Events\FooterUpdated;
use App\Filament\Resources\SocialLinks\SocialLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialLinks extends ListRecords
{
    protected static string $resource = SocialLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Broadcast to all other connected clients via Reverb
        broadcast(new FooterUpdated())->toOthers();
    }
}
