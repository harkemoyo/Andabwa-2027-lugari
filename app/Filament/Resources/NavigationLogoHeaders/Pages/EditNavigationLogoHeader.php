<?php

namespace App\Filament\Resources\NavigationLogoHeaders\Pages;

use App\Filament\Resources\NavigationLogoHeaders\NavigationLogoHeaderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNavigationLogoHeader extends EditRecord
{
    protected static string $resource = NavigationLogoHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
