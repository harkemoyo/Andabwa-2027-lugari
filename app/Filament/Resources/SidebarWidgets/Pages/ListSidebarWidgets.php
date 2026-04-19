<?php

namespace App\Filament\Resources\SidebarWidgets\Pages;

use App\Filament\Resources\SidebarWidgets\SidebarWidgetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSidebarWidgets extends ListRecords
{
    protected static string $resource = SidebarWidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
