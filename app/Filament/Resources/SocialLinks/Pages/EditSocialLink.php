<?php

namespace App\Filament\Resources\SocialLinks\Pages;

use App\Events\FooterUpdated;
use App\Filament\Resources\SocialLinks\SocialLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSocialLink extends EditRecord
{
    protected static string $resource = SocialLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

     protected function afterSave(): void
    {
        // Broadcast to all other connected clients via Reverb
        broadcast(new FooterUpdated())->toOthers();
    }
}
