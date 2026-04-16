<?php

namespace App\Filament\Resources\NavigationLogoHeaders\Pages;

use App\Filament\Resources\NavigationLogoHeaders\NavigationLogoHeaderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNavigationLogoHeaders extends ListRecords
{
    protected static string $resource = NavigationLogoHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
